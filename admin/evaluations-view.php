<?php
namespace CJM\Admin;

defined('ABSPATH') || exit;

class Evaluations_View
{
    public static function render(int $application_id)
    {
        $scoring = new \CJM\Evaluations\Scoring();
        $db = new \CJM\Database\Evaluations();
        
        $data = [
            'average' => $scoring->calculate_weighted_average($application_id),
            'breakdown' => $db->get_section_breakdown($application_id)
        ];
        
        include CJM_PLUGIN_PATH . 'templates/evaluations/summary.php';
    }
}