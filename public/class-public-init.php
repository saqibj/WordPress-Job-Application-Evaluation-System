<?php
namespace CJM\Public;

defined('ABSPATH') || exit;

class PublicInit
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function enqueue_assets()
    {
        wp_enqueue_style(
            'cjm-public',
            CJM_PLUGIN_URL . 'public/css/frontend.css',
            [],
            CJM_PLUGIN_VERSION
        );

        wp_enqueue_script(
            'cjm-public',
            CJM_PLUGIN_URL . 'public/js/frontend.js',
            ['jquery'],
            CJM_PLUGIN_VERSION,
            true
        );

        wp_localize_script('cjm-public', 'cjm_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cjm_public_nonce')
        ]);
    }
}