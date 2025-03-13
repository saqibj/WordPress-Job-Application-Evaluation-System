<?php
namespace CJM\Security;

defined('ABSPATH') || exit;

class Validation
{
    public static function is_valid_email(string $email): bool
    {
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function is_valid_resume(array $file): bool
    {
        $allowed_types = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        return in_array($file['type'], $allowed_types) && 
               $file['size'] <= (1024 * 1024 * (int) get_option('cjm_resume_size_limit', 2));
    }

    public static function verify_recaptcha(string $response): bool
    {
        $secret = get_option('cjm_recaptcha_secret');
        $verify = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
            'body' => [
                'secret' => $secret,
                'response' => $response
            ]
        ]);

        return json_decode(wp_remote_retrieve_body($verify))->success ?? false;
    }
}