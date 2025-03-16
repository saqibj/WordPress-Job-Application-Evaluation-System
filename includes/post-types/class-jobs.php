<?php
namespace CJM\PostTypes;

defined('ABSPATH') || exit;

class Jobs
{
    public function __construct()
    {
        \add_action('init', [$this, 'register_post_type']);
        \add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        \add_action('save_post', [$this, 'save_meta_data']);
    }

    public function register_post_type()
    {
        \register_post_type('cjm_job',
            [
                'labels' => [
                    'name' => \__('Jobs', 'job-eval-system'),
                    'singular_name' => \__('Job', 'job-eval-system'),
                    'add_new' => \__('Add New Job', 'job-eval-system'),
                    'add_new_item' => \__('Add New Job', 'job-eval-system'),
                    'edit_item' => \__('Edit Job', 'job-eval-system'),
                    'view_item' => \__('View Job', 'job-eval-system'),
                    'search_items' => \__('Search Jobs', 'job-eval-system'),
                    'not_found' => \__('No jobs found', 'job-eval-system'),
                    'not_found_in_trash' => \__('No jobs found in trash', 'job-eval-system')
                ],
                'public' => false,
                'publicly_queryable' => true,
                'show_ui' => true,
                'has_archive' => true,
                'rewrite' => ['slug' => 'jobs'],
                'supports' => ['title', 'editor', 'thumbnail'],
                'capability_type' => 'post',
                'show_in_rest' => true,
                'show_in_menu' => false
            ]
        );
    }

    public function add_meta_boxes()
    {
        \add_meta_box(
            'cjm_job_meta',
            \__('Job Details', 'job-eval-system'),
            [$this, 'render_meta_box'],
            'cjm_job',
            'normal',
            'high'
        );
    }

    public function render_meta_box($post)
    {
        \wp_nonce_field('cjm_job_meta_nonce', 'cjm_job_meta_nonce');
        $meta = \get_post_meta($post->ID);
        
        echo '<div class="cjm-meta-field">';
        echo '<label>'.\__('Location', 'job-eval-system').'</label>';
        echo '<input type="text" name="cjm_job_location" value="'.\esc_attr($meta['cjm_job_location'][0] ?? '').'">';
        echo '</div>';

        // Add more fields as needed
    }

    public function save_meta_data($post_id)
    {
        if (!isset($_POST['cjm_job_meta_nonce']) || 
            !\wp_verify_nonce($_POST['cjm_job_meta_nonce'], 'cjm_job_meta_nonce')) {
            return;
        }

        if (isset($_POST['cjm_job_location'])) {
            \update_post_meta(
                $post_id,
                'cjm_job_location',
                \sanitize_text_field($_POST['cjm_job_location'])
            );
        }
    }
}