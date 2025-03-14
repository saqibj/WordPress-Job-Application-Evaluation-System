<?php
namespace CJM\Shortcodes;

defined('ABSPATH') || exit;

class ApplicationForm
{
    public function __construct()
    {
        add_shortcode('cjm_apply', [$this, 'render']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function enqueue_assets()
    {
        wp_enqueue_style('cjm-forms', CJM_PLUGIN_URL . 'public/css/frontend.css');
        wp_enqueue_script('cjm-application-form', CJM_PLUGIN_URL . 'public/js/application-form.js', 
            ['jquery'], CJM_PLUGIN_VERSION, true);
    }

    public function render($atts)
    {
        if (!is_singular('cjm_job') && empty($atts['job_id'])) {
            return '<div class="cjm-error">'.__('No job specified').'</div>';
        }

        ob_start();
        $job_id = $atts['job_id'] ?? get_the_ID();
        include CJM_TEMPLATE_PATH . 'applications/form-application.php';
        return ob_get_clean();
    }

    public static function handle_submission()
    {
        if (!isset($_POST['cjm_application_nonce'])) {
            return;
        }
        
        // Validation and processing logic
    }
}