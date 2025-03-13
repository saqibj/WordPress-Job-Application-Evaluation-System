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

        // Core Systems
        new TemplateLoader();
        Notifications\Notifications::init();
        Cron\Cleanup::init();

        // API & CLI
        new Api\RestAPI();
        new CLI\CLI();

        // Frontend
        new Public\PublicInit();

        // Admin Components
        if (is_admin()) {
            require_once CJM_PLUGIN_PATH . 'admin/class-settings.php';
            new Admin\Settings();
        }
    }

    public function run()
    {
        // Future hook point for extensions
        do_action('cjm_plugin_loaded');
    }
}