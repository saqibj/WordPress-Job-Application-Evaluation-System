<?php
namespace CJM\Uploads;

defined('ABSPATH') || exit;

class FileHandler
{
    public static function handle_upload(array $file)
    {
        if (!function_exists('wp_handle_upload')) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        $upload_dir = wp_upload_dir();
        $target_dir = $upload_dir['basedir'] . '/cjm-resumes/';
        
        if (!file_exists($target_dir)) {
            wp_mkdir_p($target_dir);
        }

        $allowed = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        $overrides = [
            'test_form' => false,
            'mimes' => $allowed,
            'unique_filename_callback' => [self::class, 'generate_filename']
        ];

        return wp_handle_upload($file, $overrides);
    }

    public static function generate_filename($dir, $name, $ext)
    {
        return sanitize_file_name(
            uniqid('resume_', true) . '_' . date('Ymd') . $ext
        );
    }
}