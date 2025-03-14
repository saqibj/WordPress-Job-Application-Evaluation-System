<?php
namespace CJM\Shortcodes;

class RegistrationForm {
    public function __construct() {
        add_shortcode('cjm_registration_form', [$this, 'render_form']);
        add_action('wp_ajax_nopriv_cjm_register_applicant', [$this, 'handle_registration']);
    }

    public function render_form() {
        if (is_user_logged_in()) {
            return sprintf(
                '<p>%s</p>',
                esc_html__('You are already logged in.', 'job-eval-system')
            );
        }

        ob_start();
        include CJM_PLUGIN_PATH . 'templates/registration-form.php';
        return ob_get_clean();
    }

    public function handle_registration() {
        check_ajax_referer('cjm_registration_nonce', 'nonce');

        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);
        $phone = sanitize_text_field($_POST['phone']);

        // Validate email
        if (!is_email($email)) {
            wp_send_json_error([
                'message' => __('Please enter a valid email address.', 'job-eval-system')
            ]);
        }

        // Validate phone number (E.164 format)
        if (!preg_match('/^\+[1-9]\d{1,14}$/', $phone)) {
            wp_send_json_error([
                'message' => __('Please enter a valid phone number with country code.', 'job-eval-system')
            ]);
        }

        // Check if user exists
        if (email_exists($email)) {
            wp_send_json_error([
                'message' => __('This email address is already registered.', 'job-eval-system')
            ]);
        }

        // Create user
        $user_id = wp_create_user(
            $email,
            $password,
            $email
        );

        if (is_wp_error($user_id)) {
            wp_send_json_error([
                'message' => $user_id->get_error_message()
            ]);
        }

        // Update user meta
        wp_update_user([
            'ID' => $user_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'display_name' => $first_name . ' ' . $last_name,
        ]);

        // Save phone number
        update_user_meta($user_id, 'phone_number', $phone);

        // Assign applicant role
        $user = new \WP_User($user_id);
        $user->set_role('applicant');

        // Log the user in
        wp_set_auth_cookie($user_id);

        wp_send_json_success([
            'message' => __('Registration successful! Redirecting...', 'job-eval-system'),
            'redirect_url' => home_url('/jobs')
        ]);
    }
} 