<?php
namespace CJM;

defined('ABSPATH') || exit;

final class Plugin
{
    private static $instance;

    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->load_dependencies();
        $this->init_components();
        register_activation_hook(CJM_PLUGIN_FILE, [$this, 'activate']);
        register_deactivation_hook(CJM_PLUGIN_FILE, [$this, 'deactivate']);
        add_action('init', [$this, 'init_components']);
    }

    private function load_dependencies()
    {
        // Core Components
        require_once CJM_PLUGIN_PATH . 'includes/database/class-db-applications.php';
        require_once CJM_PLUGIN_PATH . 'includes/database/class-db-evaluations.php';
        require_once CJM_PLUGIN_PATH . 'includes/post-types/class-jobs.php';
        require_once CJM_PLUGIN_PATH . 'includes/post-types/class-applications.php';
        require_once CJM_PLUGIN_PATH . 'includes/post-types/class-evaluations.php';
        
        // Shortcodes
        require_once CJM_PLUGIN_PATH . 'includes/shortcodes/class-jobs-shortcode.php';
        require_once CJM_PLUGIN_PATH . 'includes/shortcodes/class-application-form.php';
        require_once CJM_PLUGIN_PATH . 'includes/shortcodes/class-dashboard.php';
        require_once CJM_PLUGIN_PATH . 'includes/shortcodes/class-registration-form.php';

        // Security
        require_once CJM_PLUGIN_PATH . 'includes/security/class-sanitization.php';
        require_once CJM_PLUGIN_PATH . 'includes/security/class-validation.php';
        require_once CJM_PLUGIN_PATH . 'includes/security/class-nonces.php';

        // System Components
        require_once CJM_PLUGIN_PATH . 'includes/template-loader.php';
        require_once CJM_PLUGIN_PATH . 'includes/notifications/class-emailer.php';
        require_once CJM_PLUGIN_PATH . 'includes/notifications/notifications.php';
        require_once CJM_PLUGIN_PATH . 'includes/uploads/class-file-handler.php';
        require_once CJM_PLUGIN_PATH . 'includes/uploads/resume-validator.php';
        require_once CJM_PLUGIN_PATH . 'includes/evaluations/class-scoring.php';
        require_once CJM_PLUGIN_PATH . 'includes/evaluations/calculator.php';
        require_once CJM_PLUGIN_PATH . 'includes/cron/cleanup.php';

        // API & Extensions
        require_once CJM_PLUGIN_PATH . 'includes/api/class-rest-api.php';
        require_once CJM_PLUGIN_PATH . 'includes/cli/class-cli.php';
        require_once CJM_PLUGIN_PATH . 'includes/reports/class-reports.php';

        // Admin
        if (is_admin()) {
            require_once CJM_PLUGIN_PATH . 'includes/admin/class-admin-menu.php';
        }

        // Frontend
        require_once CJM_PLUGIN_PATH . 'public/class-public-init.php';
    }

    private function init_components()
    {
        // Post Types
        new PostTypes\Jobs();
        new PostTypes\Applications();
        new PostTypes\Evaluations();

        // Shortcodes
        new Shortcodes\JobsShortcode();
        new Shortcodes\ApplicationForm();
        new Shortcodes\Dashboard();
        new Shortcodes\RegistrationForm();

        // Core Systems
        new TemplateLoader();
        Notifications\Notifications::init();
        Cron\Cleanup::init();

        // API & CLI
        new Api\RestAPI();
        new CLI\CLI();

        // Admin Components
        if (is_admin()) {
            Admin\AdminMenu::init();
        }

        // Frontend
        new Public\PublicInit();
    }

    public function run()
    {
        // Future hook point for extensions
        do_action('cjm_plugin_loaded');
    }

    public function activate() {
        // Create required database tables
        $this->create_tables();
        
        // Create custom user roles
        $this->create_roles();
        
        // Set default options
        $this->set_default_options();
        
        // Clear rewrite rules
        flush_rewrite_rules();
    }

    public function deactivate() {
        // Don't remove roles on deactivation
        // Only remove them on uninstall if needed
        
        // Clear rewrite rules
        flush_rewrite_rules();
    }

    private function create_roles() {
        // HR Manager Role
        add_role(
            'hr_manager',
            __('HR Manager', 'job-eval-system'),
            [
                'read' => true,
                'edit_posts' => true,
                'delete_posts' => true,
                'publish_posts' => true,
                'upload_files' => true,
                'manage_job_posts' => true,
                'view_applications' => true,
                'manage_applications' => true,
                'assign_evaluators' => true,
                'view_evaluations' => true,
                'export_data' => true,
                'manage_settings' => true,
            ]
        );

        // Interviewer Role
        add_role(
            'interviewer',
            __('Interviewer', 'job-eval-system'),
            [
                'read' => true,
                'upload_files' => true,
                'view_applications' => true,
                'create_evaluations' => true,
                'edit_evaluations' => true,
                'view_evaluations' => true,
            ]
        );

        // Applicant Role
        add_role(
            'applicant',
            __('Applicant', 'job-eval-system'),
            [
                'read' => true,
                'upload_files' => true,
                'edit_application' => true,
                'view_own_application' => true,
                'submit_application' => true,
            ]
        );

        // Add HR capabilities to administrator role
        $admin = get_role('administrator');
        if ($admin) {
            $admin->add_cap('manage_job_posts');
            $admin->add_cap('view_applications');
            $admin->add_cap('manage_applications');
            $admin->add_cap('assign_evaluators');
            $admin->add_cap('view_evaluations');
            $admin->add_cap('create_evaluations');
            $admin->add_cap('edit_evaluations');
            $admin->add_cap('export_data');
            $admin->add_cap('manage_settings');
        }
    }

    private function set_default_options() {
        // Set default options if they don't exist
        if (!get_option('cjm_resume_size_limit')) {
            update_option('cjm_resume_size_limit', 2); // 2MB default
        }
        
        if (!get_option('cjm_data_retention')) {
            update_option('cjm_data_retention', 365); // 1 year default
        }
        
        if (!get_option('cjm_testing_mode')) {
            update_option('cjm_testing_mode', 0); // Testing mode disabled by default
        }
    }

    private function create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        // Applications meta table
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}cjm_application_meta (
            meta_id bigint(20) NOT NULL AUTO_INCREMENT,
            application_id bigint(20) NOT NULL,
            meta_key varchar(255) DEFAULT NULL,
            meta_value longtext,
            PRIMARY KEY  (meta_id),
            KEY application_id (application_id),
            KEY meta_key (meta_key(191))
        ) $charset_collate;";

        // Evaluations meta table
        $sql .= "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}cjm_evaluation_meta (
            meta_id bigint(20) NOT NULL AUTO_INCREMENT,
            evaluation_id bigint(20) NOT NULL,
            meta_key varchar(255) DEFAULT NULL,
            meta_value longtext,
            PRIMARY KEY  (meta_id),
            KEY evaluation_id (evaluation_id),
            KEY meta_key (meta_key(191))
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}