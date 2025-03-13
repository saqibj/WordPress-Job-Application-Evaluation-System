<?php
namespace CJM\PostTypes;

defined('ABSPATH') || exit;

class Jobs
{
    public function __construct()
    {
        add_action('init', [$this, 'register_post_type']);
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post', [$this, 'save_meta_data']);
    }

    public function register_post_type()
    {
        register_post_type('cjm_job',
            [
                'labels' => [
                    'name' => __('Jobs'),
                    'singular_name' => __('Job')
                ],
                'public' => true,
                'has_archive' => true,
                'rewrite' => ['slug' => 'jobs'],
                'supports' => ['title', 'editor', 'thumbnail'],
                'capability_type' => 'post',
                'show_in_rest' => true,
                'menu_icon' => 'dashicons-businessperson'
            ]
        );
    }

    public function add_meta_boxes()
    {
        add_meta_box(
            'cjm_job_meta',
            __('Job Details'),
            [$this, 'render_meta_box'],
            'cjm_job',
            'normal',
            'high'
        );
    }

    public function render_meta_box($post)
    {
        wp_nonce_field('cjm_job_meta_nonce', 'cjm_job_meta_nonce');
        $meta = get_post_meta($post->ID);
        
        echo '<div class="cjm-meta-field">';
        echo '<label>'.__('Location').'</label>';
        echo '<input type="text" name="cjm_job_location" value="'.esc_attr($meta['cjm_job_location'][0] ?? '').'">';
        echo '</div>';

        // Add more fields as needed
    }

    public function save_meta_data($post_id)
    {
        if (!isset($_POST['cjm_job_meta_nonce']) || 
            !wp_verify_nonce($_POST['cjm_job_meta_nonce'], 'cjm_job_meta_nonce')) {
            return;
        }

        if (isset($_POST['cjm_job_location'])) {
            update_post_meta(
                $post_id,
                'cjm_job_location',
                sanitize_text_field($_POST['cjm_job_location'])
            );
        }
    }
}