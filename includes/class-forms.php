<?php

class Forms {
    public function validate_recaptcha($token) {
        // Skip validation if testing mode is enabled
        if (get_option('cjm_testing_mode', 0)) {
            return true;
        }

        $secret_key = get_option('cjm_recaptcha_secret_key', '');
        
        if (empty($secret_key)) {
            return false;
        }

        $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
            'body' => [
                'secret' => $secret_key,
                'response' => $token
            ]
        ]);

        if (is_wp_error($response)) {
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body, true);

        return isset($result['success']) && $result['success'] === true;
    }
} 