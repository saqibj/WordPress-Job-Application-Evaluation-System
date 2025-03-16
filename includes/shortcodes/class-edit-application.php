<?php
namespace CJM\Shortcodes;

defined('ABSPATH') || exit;

class EditApplication {
    public function __construct() {
        add_shortcode('cjm_edit_application', [$this, 'render_form']);
        add_action('wp_ajax_cjm_edit_application', [$this, 'handle_edit']);
        add_action('init', [$this, 'add_rewrite_rules']);
        add_filter('query_vars', [$this, 'add_query_vars']);
    }

    public function add_rewrite_rules() {
        add_rewrite_rule(
            'applications/edit/([0-9]+)/?$',
            'index.php?pagename=applications&application_id=$matches[1]',
            'top'
        );
    }

    public function add_query_vars($vars) {
        $vars[] = 'application_id';
        return $vars;
    }

    public function render_form() {
        if (!is_user_logged_in()) {
            return sprintf(
                '<p>%s</p>',
                esc_html__('You must be logged in to edit applications.', 'job-eval-system')
            );
        }

        ob_start();
        include CJM_PLUGIN_PATH . 'templates/applications/edit-application.php';
        return ob_get_clean();
    }

    public function handle_edit() {
        check_ajax_referer('cjm_edit_application', 'cjm_edit_application_nonce');

        $application_id = absint($_POST['application_id']);
        $application = get_post($application_id);

        // Security checks
        if (!$application || 
            $application->post_type !== 'cjm_application' || 
            !current_user_can('edit_application', $application_id) || 
            get_current_user_id() != $application->post_author) {
            wp_send_json_error([
                'message' => __('You do not have permission to edit this application.', 'job-eval-system')
            ]);
        }

        // Validate and sanitize input
        $candidate_name = sanitize_text_field($_POST['candidate_name']);
        $candidate_email = sanitize_email($_POST['candidate_email']);
        $phone = sanitize_text_field($_POST['phone']);

        // Validate phone number (E.164 format)
        if (!preg_match('/^\+[1-9]\d{1,14}$/', $phone)) {
            wp_send_json_error([
                'message' => __('Please enter a valid phone number with country code.', 'job-eval-system')
            ]);
        }

        // Update application meta
        update_post_meta($application_id, 'cjm_candidate_name', $candidate_name);
        update_post_meta($application_id, 'cjm_candidate_email', $candidate_email);
        update_post_meta($application_id, 'cjm_phone', $phone);

        // Handle resume upload if provided
        if (!empty($_FILES['new_resume']['name'])) {
            $resume_size_limit = get_option('cjm_resume_size_limit', 2) * 1024 * 1024; // Convert MB to bytes
            
            if ($_FILES['new_resume']['size'] > $resume_size_limit) {
                wp_send_json_error([
                    'message' => sprintf(
                        __('Resume file size must be less than %sMB.', 'job-eval-system'),
                        get_option('cjm_resume_size_limit', 2)
                    )
                ]);
            }

            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');

            $attachment_id = media_handle_upload('new_resume', 0);
            
            if (is_wp_error($attachment_id)) {
                wp_send_json_error([
                    'message' => $attachment_id->get_error_message()
                ]);
            }

            $resume_url = wp_get_attachment_url($attachment_id);
            update_post_meta($application_id, 'cjm_resume_path', $resume_url);
            update_post_meta($application_id, 'cjm_resume_attachment_id', $attachment_id);
        }

        // Log the edit
        update_post_meta($application_id, 'cjm_last_edited', current_time('mysql'));
        
        wp_send_json_success([
            'message' => __('Application updated successfully!', 'job-eval-system'),
            'redirect_url' => add_query_arg('updated', '1', get_permalink($application_id))
        ]);
    }
} 