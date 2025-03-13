<?php
namespace CJM\Shortcodes;

defined('ABSPATH') || exit;

class Dashboard
{
    public function __construct()
    {
        add_shortcode('cjm_dashboard', [$this, 'render']);
    }

    public function render()
    {
        if (!is_user_logged_in() || !current_user_can('cjm_interviewer')) {
            return '<div class="cjm-error">'.__('Access denied').'</div>';
        }

        ob_start();
        $applications = $this->get_assigned_applications();
        include CJM_TEMPLATE_PATH . 'evaluations/dashboard.php';
        return ob_get_clean();
    }

    private function get_assigned_applications()
    {
        global $wpdb;
        $user_id = get_current_user_id();
        
        return $wpdb->get_results(
            $wpdb->prepare(
                "SELECT a.* FROM {$wpdb->prefix}cjm_applications a
                INNER JOIN {$wpdb->prefix}postmeta pm
                ON a.application_id = pm.meta_value
                WHERE pm.meta_key = 'assigned_interviewers'
                AND pm.post_id = %d",
                $user_id
            )
        );
    }
}