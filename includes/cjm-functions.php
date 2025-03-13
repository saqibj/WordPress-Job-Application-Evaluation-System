<?php
namespace CJM;

defined('ABSPATH') || exit;

function get_evaluation_form(int $application_id)
{
    $criteria = apply_filters('cjm_evaluation_criteria', [
        'core' => \CJM\Evaluations\Criteria\CoreCompetencies::get_criteria(),
        'role_specific' => \CJM\Evaluations\Criteria\RoleSpecific::get_criteria(),
        'behavioral' => \CJM\Evaluations\Criteria\Behavioral::get_criteria()
    ]);

    ob_start();
    include CJM_TEMPLATE_PATH . 'evaluations/form-evaluation.php';
    return ob_get_clean();
}

function format_rating(int $rating)
{
    $labels = \CJM\Evaluations\Criteria\CoreCompetencies::get_rating_labels();
    return $labels[$rating] ?? __('Not Rated');
}

function get_candidate_portal_url()
{
    return apply_filters('cjm_candidate_portal_url', home_url('/applications'));
}