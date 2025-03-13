<?php
/**
 * Database schema installation
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create custom database tables
 */
function cjm_create_database_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Applications Table
    $applications_table = $wpdb->prefix . 'cjm_applications';
    $applications_sql = "CREATE TABLE $applications_table (
        application_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        job_id BIGINT UNSIGNED NOT NULL,
        candidate_name VARCHAR(255) NOT NULL,
        candidate_email VARCHAR(100) NOT NULL,
        resume_path VARCHAR(255) NOT NULL,
        status ENUM('new', 'in_review', 'archived') NOT NULL DEFAULT 'new',
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY  (application_id),
        INDEX job_index (job_id),
        INDEX status_index (status)
    ) $charset_collate;";

    // Evaluations Table
    $evaluations_table = $wpdb->prefix . 'cjm_evaluations';
    $evaluations_sql = "CREATE TABLE $evaluations_table (
        evaluation_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        application_id BIGINT UNSIGNED NOT NULL,
        interviewer_id BIGINT UNSIGNED NOT NULL,
        section ENUM('core', 'role_specific', 'behavioral') NOT NULL,
        criterion VARCHAR(255) NOT NULL,
        rating TINYINT UNSIGNED,
        comments TEXT,
        evaluated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (evaluation_id),
        INDEX app_interviewer_index (application_id, interviewer_id),
        INDEX criterion_index (criterion),
        FOREIGN KEY (application_id) REFERENCES $applications_table(application_id) ON DELETE CASCADE
    ) $charset_collate;";

    // Execute SQL
    dbDelta($applications_sql);
    dbDelta($evaluations_sql);

    // Log any errors
    if (!empty($wpdb->last_error)) {
        error_log('CJM Plugin Table Creation Error: ' . $wpdb->last_error);
    }
}