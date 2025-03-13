<?php
namespace CJM\PostTypes;

defined('ABSPATH') || exit;

class Applications
{
    public function __construct()
    {
        add_action('init', [$this, 'register_post_type']);
        add_filter('manage_cjm_application_posts_columns', [$this, 'custom_columns']);
        add_action('manage_cjm_application_posts_custom_column', [$this, 'column_content'], 10, 2);
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post_cjm_application', [$this, 'save_application'], 10, 3);
        add_filter('post_updated_messages', [$this, 'custom_messages']);
    }

    /**
     * Register custom post type
     */
    public function register_post_type()
    {
        $labels = [
            'name'                  => _x('Applications', 'Post Type General Name', 'job-eval-system'),
            'singular_name'         => _x('Application', 'Post Type Singular Name', 'job-eval-system'),
            'menu_name'             => __('Job Applications', 'job-eval-system'),
            'all_items'             => __('All Applications', 'job-eval-system'),
            'view_item'            => __('View Application', 'job-eval-system'),
            'add_new_item'          => __('Add New Application', 'job-eval-system'),
            'add_new'              => __('Add New', 'job-eval-system'),
            'edit_item'             => __('Edit Application', 'job-eval-system'),
            'search_items'         => __('Search Applications', 'job-eval-system'),
        ];

        $capabilities = [
            'edit_post'             => 'edit_cjm_application',
            'read_post'             => 'read_cjm_application',
            'delete_post'           => 'delete_cjm_application',
            'edit_posts'            => 'edit_cjm_applications',
            'edit_others_posts'     => 'edit_others_cjm_applications',
            'publish_posts'         => 'publish_cjm_applications',
            'read_private_posts'    => 'read_private_cjm_applications',
        ];

        register_post_type('cjm_application', [
            'label'                => __('Application', 'job-eval-system'),
            'description'          => __('Job applications with candidate information', 'job-eval-system'),
            'labels'               => $labels,
            'supports'             => ['title'],
            'capability_type'      => 'cjm_application',
            'capabilities'         => $capabilities,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => 'edit.php?post_type=cjm_job',
            'map_meta_cap'        => true,
            'has_archive'         => false,
            'rewrite'             => false,
            'show_in_rest'        => false,
        ]);

        $this->register_post_statuses();
    }

    /**
     * Register custom post statuses
     */
    private function register_post_statuses()
    {
        register_post_status('new', [
            'label'                     => _x('New', 'application status', 'job-eval-system'),
            'public'                    => true,
            'internal'                  => true,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('New <span class="count">(%s)</span>', 'New <span class="count">(%s)</span>', 'job-eval-system'),
        ]);

        // Add more statuses: interviewed, hired, rejected etc
    }

    /**
     * Add custom meta boxes
     */
    public function add_meta_boxes()
    {
        add_meta_box(
            'cjm_application_details',
            __('Application Details', 'job-eval-system'),
            [$this, 'render_application_meta'],
            'cjm_application',
            'normal',
            'high'
        );
    }

    /**
     * Render meta box content
     */
    public function render_application_meta($post)
    {
        wp_nonce_field('cjm_application_meta_nonce', 'cjm_application_meta_nonce');
        
        $job_id = get_post_meta($post->ID, 'cjm_job_id', true);
        $candidate_email = get_post_meta($post->ID, 'cjm_candidate_email', true);
        $resume_url = get_post_meta($post->ID, 'cjm_resume_path', true);
        $submission_date = get_post_meta($post->ID, 'cjm_submission_date', true);

        include CJM_PLUGIN_PATH . 'templates/admin/application-details.php';
    }

    /**
     * Save application meta data
     */
    public function save_application($post_id, $post, $update)
    {
        if (!isset($_POST['cjm_application_meta_nonce'])) {
            return;
        }
        if (!wp_verify_nonce($_POST['cjm_application_meta_nonce'], 'cjm_application_meta_nonce')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!current_user_can('edit_cjm_application', $post_id)) {
            return;
        }

        $fields = [
            'cjm_job_id' => 'absint',
            'cjm_candidate_email' => 'sanitize_email',
            'cjm_resume_path' => 'esc_url_raw',
            'cjm_submission_date' => 'sanitize_text_field'
        ];

        foreach ($fields as $key => $sanitizer) {
            if (isset($_POST[$key])) {
                $value = call_user_func($sanitizer, $_POST[$key]);
                update_post_meta($post_id, $key, $value);
            }
        }
    }

    /**
     * Customize admin columns
     */
    public function custom_columns($columns)
    {
        unset($columns['date']);
        return array_merge($columns, [
            'job' => __('Job Position', 'job-eval-system'),
            'candidate' => __('Candidate', 'job-eval-system'),
            'status' => __('Status', 'job-eval-system'),
            'date' => __('Date Applied', 'job-eval-system')
        ]);
    }

    /**
     * Populate custom columns
     */
    public function column_content($column, $post_id)
    {
        switch ($column) {
            case 'job':
                $job_id = get_post_meta($post_id, 'cjm_job_id', true);
                echo $job_id ? '<a href="'.get_edit_post_link($job_id).'">'.get_the_title($job_id).'</a>' : '—';
                break;

            case 'candidate':
                echo esc_html(get_the_title($post_id)).'<br>';
                echo '<small>'.sanitize_email(get_post_meta($post_id, 'cjm_candidate_email', true)).'</small>';
                break;

            case 'status':
                $status = get_post_status_object(get_post_status($post_id));
                echo '<span class="cjm-status-badge status-'.esc_attr($status->name).'">';
                echo esc_html($status->label);
                echo '</span>';
                break;
        }
    }

    /**
     * Custom post update messages
     */
    public function custom_messages($messages)
    {
        $messages['cjm_application'] = [
            1 => __('Application updated.', 'job-eval-system'),
            6 => __('Application submitted.', 'job-eval-system'),
            9 => __('Application scheduled.', 'job-eval-system'),
            10 => __('Application draft updated.', 'job-eval-system'),
        ];
        return $messages;
    }

    /**
     * Helper: Get application status
     */
    public static function get_status($post_id)
    {
        return get_post_status($post_id);
    }

    /**
     * Helper: Get application job ID
     */
    public static function get_job_id($post_id)
    {
        return get_post_meta($post_id, 'cjm_job_id', true);
    }
}