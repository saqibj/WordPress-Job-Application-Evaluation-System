<?php
namespace CJM\Cron;

defined('ABSPATH') || exit;

class Cleanup
{
    public static function init()
    {
        add_action('cjm_daily_cleanup', [self::class, 'purge_old_data']);
        
        if (!wp_next_scheduled('cjm_daily_cleanup')) {
            wp_schedule_event(time(), 'daily', 'cjm_daily_cleanup');
        }
    }

    public static function purge_old_data()
    {
        global $wpdb;
        $retention_days = get_option('cjm_data_retention', 365);
        
        $wpdb->query(
            $wpdb->prepare(
                "DELETE a, e FROM {$wpdb->prefix}cjm_applications a
                LEFT JOIN {$wpdb->prefix}cjm_evaluations e
                ON a.application_id = e.application_id
                WHERE a.created_at < DATE_SUB(NOW(), INTERVAL %d DAY)",
                $retention_days
            )
        );
    }
}