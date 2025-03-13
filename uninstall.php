<?php
// Exit if uninstall not called from WordPress
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Remove database tables
global $wpdb;
$tables = [
    $wpdb->prefix . 'cjm_applications',
    $wpdb->prefix . 'cjm_evaluations'
];

foreach ($tables as $table) {
    $wpdb->query("DROP TABLE IF EXISTS $table");
}

// Remove options
delete_option('cjm_resume_size_limit');
delete_option('cjm_data_retention');

// Clear scheduled events
wp_clear_scheduled_hook('cjm_daily_cleanup');