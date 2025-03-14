<?php
// If uninstall not called from WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Remove custom roles
remove_role('hr_manager');
remove_role('interviewer');

// Remove capabilities from administrator role
$admin = get_role('administrator');
if ($admin) {
    $admin->remove_cap('manage_job_posts');
    $admin->remove_cap('view_applications');
    $admin->remove_cap('manage_applications');
    $admin->remove_cap('assign_evaluators');
    $admin->remove_cap('view_evaluations');
    $admin->remove_cap('create_evaluations');
    $admin->remove_cap('edit_evaluations');
    $admin->remove_cap('export_data');
    $admin->remove_cap('manage_settings');
}

// Remove plugin options
delete_option('cjm_resume_size_limit');
delete_option('cjm_data_retention');
delete_option('cjm_recaptcha_site_key');
delete_option('cjm_recaptcha_secret_key');
delete_option('cjm_testing_mode');

// Drop custom tables
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}cjm_application_meta");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}cjm_evaluation_meta");

// Remove database tables
$tables = [
    $wpdb->prefix . 'cjm_applications',
    $wpdb->prefix . 'cjm_evaluations'
];

foreach ($tables as $table) {
    $wpdb->query("DROP TABLE IF EXISTS $table");
}

// Clear scheduled events
wp_clear_scheduled_hook('cjm_daily_cleanup');