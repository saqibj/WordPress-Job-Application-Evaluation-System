<?php
namespace CJM\Notifications;

defined('ABSPATH') || exit;

class Notifications
{
    public function init()
    {
        add_action('cjm_application_submitted', [$this, 'new_application_notification'], 10, 2);
        add_action('cjm_evaluation_completed', [$this, 'evaluation_complete_notification']);
    }

    public function new_application_notification(int $application_id, int $job_id)
    {
        $application = (new \CJM\Database\Applications())->get_application($application_id);
        $job_title = get_the_title($job_id);

        Emailer::send(
            get_option('admin_email'),
            __('New Job Application Received'),
            'new-application.html',
            [
                'job_title' => $job_title,
                'candidate_name' => $application->candidate_name,
                'candidate_email' => $application->candidate_email,
                'admin_url' => admin_url("post.php?post=$application_id&action=edit")
            ]
        );
    }

    public function evaluation_complete_notification(int $application_id)
    {
        $application = (new \CJM\Database\Applications())->get_application($application_id);
        $average_score = (new \CJM\Evaluations\Scoring())->calculate_weighted_average($application_id);

        Emailer::send(
            get_option('admin_email'),
            __('Evaluation Completed'),
            'evaluation-complete.html',
            [
                'candidate_name' => $application->candidate_name,
                'job_title' => get_the_title($application->job_id),
                'average_score' => $average_score,
                'report_url' => admin_url("admin.php?page=cjm-reports&application=$application_id")
            ]
        );
    }
}