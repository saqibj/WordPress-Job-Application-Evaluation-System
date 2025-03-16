<?php
/**
 * Uninstall handler for Job Application & Evaluation System
 * 
 * This file runs when the plugin is uninstalled via the Plugins screen.
 */

// Exit if not called by WordPress
if (!defined('WP_UNINSTALL_PLUGIN') || !defined('ABSPATH')) {
    die('Direct access not allowed.');
}

// Make sure WordPress core is loaded
if (!function_exists('get_option')) {
    require_once(ABSPATH . 'wp-load.php');
}

// Access WordPress database object
global $wpdb;

try {
    // Delete all posts of custom post types
    $post_types = ['cjm_job', 'cjm_application', 'cjm_evaluation'];
    foreach ($post_types as $post_type) {
        $query = $wpdb->prepare("
            SELECT ID FROM {$wpdb->posts} 
            WHERE post_type = %s
        ", $post_type);
        
        $post_ids = $wpdb->get_col($query);
        foreach ($post_ids as $post_id) {
            wp_delete_post($post_id, true);
        }
    }

    // Drop custom tables in correct order (respecting foreign key constraints)
    $tables = [
        // First drop tables with foreign key dependencies
        $wpdb->prefix . 'cjm_evaluation_meta',    // Depends on evaluations
        $wpdb->prefix . 'cjm_application_meta',   // Depends on applications
        $wpdb->prefix . 'cjm_previous_jobs',      // Depends on applications
        $wpdb->prefix . 'cjm_skills',             // Depends on applications
        $wpdb->prefix . 'cjm_evaluations',        // Depends on applications
        // Finally drop the main applications table
        $wpdb->prefix . 'cjm_applications'        // No dependencies
    ];

    foreach ($tables as $table) {
        $wpdb->query("DROP TABLE IF EXISTS {$table}");
    }

    // Remove plugin options
    $options = [
        'cjm_resume_size_limit',
        'cjm_data_retention',
        'cjm_testing_mode',
        'cjm_jobs_page',
        'cjm_applications_page',
        'cjm_edit_application_page',
        'cjm_dashboard_page',
        'cjm_registration_page',
        'cjm_db_version',
        'cjm_installed_time',
        'cjm_last_cleanup'
    ];

    // First collect page IDs before deleting options
    $page_ids = [];
    foreach ($options as $option) {
        if (strpos($option, '_page') !== false) {
            $page_id = get_option($option);
            if ($page_id) {
                $page_ids[] = $page_id;
            }
        }
    }

    // Now delete all options
    foreach ($options as $option) {
        delete_option($option);
    }

    // Remove plugin pages using collected IDs
    foreach ($page_ids as $page_id) {
        wp_delete_post($page_id, true);
    }

    // Remove custom roles and capabilities
    if (class_exists('WP_Roles')) {
        global $wp_roles;
        
        if (!isset($wp_roles)) {
            $wp_roles = new WP_Roles();
        }

        // Remove roles
        $roles_to_remove = ['hr_manager', 'interviewer', 'applicant'];
        foreach ($roles_to_remove as $role) {
            remove_role($role);
        }

        // Remove capabilities from administrator
        $admin = get_role('administrator');
        if ($admin) {
            $caps = [
                'manage_job_posts',
                'view_applications',
                'manage_applications',
                'assign_evaluators',
                'view_evaluations',
                'create_evaluations',
                'edit_evaluations',
                'export_data',
                'manage_settings'
            ];
            
            foreach ($caps as $cap) {
                $admin->remove_cap($cap);
            }
        }
    }

    // Clear any scheduled hooks
    wp_clear_scheduled_hook('cjm_daily_cleanup');

    // Clean up upload directory
    $upload_dir = wp_upload_dir();
    $plugin_upload_dir = rtrim($upload_dir['basedir'], '/') . '/job-eval-system';
    
    if (is_dir($plugin_upload_dir)) {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($plugin_upload_dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                @rmdir($file->getRealPath());
            } else {
                @unlink($file->getRealPath());
            }
        }
        @rmdir($plugin_upload_dir);
    }

    // Clean up any transients and options
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '%_cjm_%'");
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '%_transient_cjm_%'");
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '%_transient_timeout_cjm_%'");

    // Clear rewrite rules
    flush_rewrite_rules();

} catch (Exception $e) {
    error_log('Job Application System uninstall error: ' . $e->getMessage());
}