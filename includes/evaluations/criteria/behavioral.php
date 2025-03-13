<?php
namespace CJM\Evaluations\Criteria;

defined('ABSPATH') || exit;

class Behavioral
{
    public static function get_criteria(): array
    {
        return [
            'teamwork' => __('Teamwork & Collaboration'),
            'initiative' => __('Initiative & Proactiveness'),
            'adaptability' => __('Adaptability & Flexibility'),
            'time_management' => __('Time Management'),
            'cultural_fit' => __('Cultural Fit')
        ];
    }
}