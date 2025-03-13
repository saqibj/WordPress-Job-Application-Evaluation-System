<?php
namespace CJM\Evaluations\Criteria;

defined('ABSPATH') || exit;

class RoleSpecific
{
    public static function get_criteria(): array
    {
        return [
            'relevant_experience' => __('Relevant Experience'),
            'data_analysis' => __('Data Analysis & Interpretation'),
            'reporting_skills' => __('Reporting & Presentation'),
            'technical_expertise' => __('Technical Expertise'),
            'tool_proficiency' => __('Tool Proficiency')
        ];
    }
}