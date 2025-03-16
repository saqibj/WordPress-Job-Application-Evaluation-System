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
        $this->init_core_components();
        \register_activation_hook(\CJM_PLUGIN_FILE, [$this, 'activate']);
        \register_deactivation_hook(\CJM_PLUGIN_FILE, [$this, 'deactivate']);
        \add_action('init', [$this, 'init_components']);
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
        if (\is_admin()) {
            require_once CJM_PLUGIN_PATH . 'includes/admin/class-admin-menu.php';
        }

        // Frontend
        require_once CJM_PLUGIN_PATH . 'public/class-public-init.php';
    }

    /**
     * Initialize core components that need to be loaded immediately
     */
    private function init_core_components()
    {
        // Post Types
        new PostTypes\Jobs();
        new PostTypes\Applications();
        new PostTypes\Evaluations();

        // Core Systems
        new TemplateLoader();
        Notifications\Notifications::init();
        Cron\Cleanup::init();

        // API & CLI
        new Api\RestAPI();
        new CLI\CLI();

        // Admin Components
        if (\is_admin()) {
            Admin\AdminMenu::init();
        }
    }

    /**
     * Initialize components that need to be loaded on WordPress init
     */
    public function init_components()
    {
        // Initialize shortcodes
        require_once CJM_PLUGIN_PATH . 'includes/shortcodes/class-registration-form.php';
        require_once CJM_PLUGIN_PATH . 'includes/shortcodes/class-application-form.php';
        require_once CJM_PLUGIN_PATH . 'includes/shortcodes/class-edit-application.php';
        require_once CJM_PLUGIN_PATH . 'includes/shortcodes/class-jobs-shortcode.php';
        require_once CJM_PLUGIN_PATH . 'includes/shortcodes/class-dashboard.php';

        new Shortcodes\RegistrationForm();
        new Shortcodes\ApplicationForm();
        new Shortcodes\EditApplication();
        new Shortcodes\JobsShortcode();
        new Shortcodes\Dashboard();

        // Initialize post types
        new PostTypes\Jobs();
        new PostTypes\Applications();
        new PostTypes\Evaluations();

        // Initialize admin components if in admin
        if (\is_admin()) {
            new Admin\AdminMenu();
        }

        // Enqueue scripts and styles
        \add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function enqueue_assets() {
        // Existing enqueues...

        // Add application form script
        \wp_enqueue_script(
            'cjm-application-form',
            CJM_PLUGIN_URL . 'public/js/application-form.js',
            ['jquery'],
            CJM_PLUGIN_VERSION,
            true
        );

        \wp_localize_script('cjm-application-form', 'cjm_i18n', [
            'company_name' => \__('Company Name', 'job-eval-system'),
            'job_title' => \__('Job Title', 'job-eval-system'),
            'start_date' => \__('Start Date', 'job-eval-system'),
            'remove' => \__('Remove', 'job-eval-system'),
            'required_field' => \__('This field is required', 'job-eval-system'),
            'select_one_skill' => \__('Please select at least one technical skill', 'job-eval-system'),
            'file_too_large' => \sprintf(
                \__('File size must be less than %sMB', 'job-eval-system'),
                \get_option('cjm_resume_size_limit', 2)
            ),
            'max_resume_size' => \get_option('cjm_resume_size_limit', 2)
        ]);

        // Add edit application script
        \wp_enqueue_script(
            'cjm-edit-application',
            CJM_PLUGIN_URL . 'public/js/edit-application.js',
            ['jquery'],
            CJM_PLUGIN_VERSION,
            true
        );

        \wp_localize_script('cjm-edit-application', 'cjm_ajax', [
            'ajax_url' => \admin_url('admin-ajax.php'),
            'nonce' => \wp_create_nonce('cjm_edit_application')
        ]);
    }

    public function run()
    {
        // Future hook point for extensions
        \do_action('cjm_plugin_loaded');
    }

    public function activate() {
        // Create required database tables
        $this->create_tables();
        
        // Create custom user roles
        $this->create_roles();
        
        // Set default options
        $this->set_default_options();
        
        // Clear rewrite rules
        \flush_rewrite_rules();

        // Create plugin pages
        self::create_plugin_pages();
    }

    public function deactivate() {
        // Don't remove roles on deactivation
        // Only remove them on uninstall if needed
        
        // Clear rewrite rules
        \flush_rewrite_rules();
    }

    private function create_roles() {
        // HR Manager Role
        \add_role(
            'hr_manager',
            \__('HR Manager', 'job-eval-system'),
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
        \add_role(
            'interviewer',
            \__('Interviewer', 'job-eval-system'),
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
        \add_role(
            'applicant',
            \__('Applicant', 'job-eval-system'),
            [
                'read' => true,
                'upload_files' => true,
                'edit_application' => true,
                'view_own_application' => true,
                'submit_application' => true,
            ]
        );

        // Add HR capabilities to administrator role
        $admin = \get_role('administrator');
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

    /**
     * Create required plugin pages
     */
    public static function create_plugin_pages() {
        $pages = [
            'cjm_jobs_page' => [
                'title' => \__('Jobs', 'job-eval-system'),
                'content' => '[cjm_jobs]'
            ],
            'cjm_applications_page' => [
                'title' => \__('My Applications', 'job-eval-system'),
                'content' => '[cjm_my_applications]'
            ],
            'cjm_edit_application_page' => [
                'title' => \__('Edit Application', 'job-eval-system'),
                'content' => '[cjm_edit_application]'
            ],
            'cjm_dashboard_page' => [
                'title' => \__('Interviewer Dashboard', 'job-eval-system'),
                'content' => '[cjm_dashboard]'
            ],
            'cjm_registration_page' => [
                'title' => \__('Register', 'job-eval-system'),
                'content' => '[cjm_registration_form]'
            ]
        ];

        foreach ($pages as $option_name => $page_data) {
            $existing_page_id = \get_option($option_name);
            
            // Skip if page already exists
            if ($existing_page_id && \get_post($existing_page_id)) {
                continue;
            }

            // Create page
            $page_id = \wp_insert_post([
                'post_title' => $page_data['title'],
                'post_content' => $page_data['content'],
                'post_status' => 'publish',
                'post_type' => 'page'
            ]);

            if (!\is_wp_error($page_id)) {
                \update_option($option_name, $page_id);
            }
        }
    }

    private function set_default_options() {
        // Set default options if they don't exist
        if (!\get_option('cjm_resume_size_limit')) {
            \update_option('cjm_resume_size_limit', 2); // 2MB default
        }
        
        if (!\get_option('cjm_data_retention')) {
            \update_option('cjm_data_retention', 365); // 1 year default
        }
        
        if (!\get_option('cjm_testing_mode')) {
            \update_option('cjm_testing_mode', 0); // Testing mode disabled by default
        }
    }

    private function create_tables() {
        require_once(CJM_PLUGIN_PATH . 'includes/database/schema.php');
        cjm_create_database_tables();
    }
}