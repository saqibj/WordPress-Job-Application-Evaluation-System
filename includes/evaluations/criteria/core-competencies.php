<?php
namespace CJM\Evaluations\Criteria;

defined('ABSPATH') || exit;

class CoreCompetencies
{
    public static function get_criteria(): array
    {
        return [
            'analytical_skills' => __('Analytical Skills'),
            'technical_skills' => __('Technical Skills'),
            'communication_skills' => __('Communication Skills'),
            'business_acumen' => __('Business Acumen'),
            'problem_solving' => __('Problem Solving')
        ];
    }

    public static function get_rating_labels(): array
    {
        return [
            5 => __('Exceptional - Exceeds expectations with mastery'),
            4 => __('Strong - Consistently above average'),
            3 => __('Meets Expectations - Satisfactory performance'),
            2 => __('Needs Improvement - Inconsistent with weaknesses'),
            1 => __('Unsatisfactory - Significant gaps'),
            0 => __('N/A - Not applicable')
        ];
    }
}