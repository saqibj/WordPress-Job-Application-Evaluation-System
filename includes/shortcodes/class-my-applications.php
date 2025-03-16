<?php
namespace CJM\Shortcodes;

defined('ABSPATH') || exit;

class MyApplications {
    public function __construct() {
        add_shortcode('cjm_my_applications', [$this, 'render']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function enqueue_assets() {
        wp_enqueue_style('cjm-applications', CJM_PLUGIN_URL . 'public/css/applications.css');
    }

    public function render() {
        ob_start();
        include CJM_PLUGIN_PATH . 'templates/applications/my-applications.php';
        return ob_get_clean();
    }
} 