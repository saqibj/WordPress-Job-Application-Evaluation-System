<?php
namespace CJM\Uploads;

defined('ABSPATH') || exit;

class ResumeValidator
{
    public static function validate(array $file): array
    {
        $max_size = get_option('cjm_resume_size_limit', 2) * 1024 * 1024;
        
        if ($file['size'] > $max_size) {
            return [
                'error' => sprintf(__('File size exceeds %dMB'), 
                            get_option('cjm_resume_size_limit', 2))
            ];
        }

        $allowed_types = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        $filetype = wp_check_filetype($file['name']);
        if (!in_array($filetype['type'], $allowed_types)) {
            return ['error' => __('Invalid file type')];
        }

        return apply_filters('cjm_resume_validation', ['valid' => true], $file);
    }
}