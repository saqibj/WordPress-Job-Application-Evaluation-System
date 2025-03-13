<?php
namespace CJM\Reports;

defined('ABSPATH') || exit;

class Reports
{
    public function generate_csv(array $application_ids)
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="cjm-report-' . date('Ymd') . '.csv"');

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Candidate', 'Position', 'Avg Score', 'Status', 'Last Evaluated']);

        $apps_db = new \CJM\Database\Applications();
        $eval_db = new \CJM\Database\Evaluations();
        
        foreach ($application_ids as $app_id) {
            $app = $apps_db->get_application($app_id);
            $eval = $eval_db->get_evaluations($app_id);
            
            fputcsv($handle, [
                $app->candidate_name,
                get_the_title($app->job_id),
                number_format($eval_db->get_average_rating($app_id), 1),
                ucfirst($app->status),
                !empty($eval) ? $eval[0]->evaluated_at : 'N/A'
            ]);
        }
        
        fclose($handle);
        exit;
    }

    public function get_stats()
    {
        global $wpdb;
        return $wpdb->get_row(
            "SELECT COUNT(*) AS total_applications,
            AVG(rating) AS avg_rating,
            MAX(evaluated_at) AS last_evaluation
            FROM {$wpdb->prefix}cjm_evaluations"
        );
    }
}