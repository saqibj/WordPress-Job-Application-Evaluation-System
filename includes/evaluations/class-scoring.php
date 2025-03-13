<?php
namespace CJM\Evaluations;

defined('ABSPATH') || exit;

class Scoring
{
    private $weights = [
        'core' => 1.0,
        'role_specific' => 1.2,
        'behavioral' => 0.8
    ];

    public function calculate_weighted_average(int $application_id): float
    {
        global $wpdb;
        $table = $wpdb->prefix . 'cjm_evaluations';
        
        $scores = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT section, AVG(rating) as avg_score 
                FROM {$table} 
                WHERE application_id = %d AND rating > 0
                GROUP BY section",
                $application_id
            ),
            OBJECT_K
        );

        $total = 0;
        $weight_sum = 0;

        foreach ($scores as $section => $data) {
            $weight = $this->weights[$section] ?? 1.0;
            $total += $data->avg_score * $weight;
            $weight_sum += $weight;
        }

        return $weight_sum > 0 ? round($total / $weight_sum, 2) : 0;
    }

    public function get_section_breakdown(int $application_id): array
    {
        global $wpdb;
        return $wpdb->get_results(
            $wpdb->prepare(
                "SELECT criterion, AVG(rating) as average 
                FROM {$wpdb->prefix}cjm_evaluations 
                WHERE application_id = %d 
                GROUP BY criterion",
                $application_id
            ),
            ARRAY_A
        );
    }
}