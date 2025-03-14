<?php
/**
 * Database schema installation
 */

defined('ABSPATH') || exit;

/**
 * Create custom database tables
 */
function cjm_create_database_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // Main Applications table
    $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}cjm_applications (
        application_id bigint(20) NOT NULL AUTO_INCREMENT,
        job_id bigint(20) NOT NULL,
        user_id bigint(20) NOT NULL,
        status varchar(20) NOT NULL DEFAULT 'new',
        resume_path varchar(255) DEFAULT NULL,
        created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (application_id),
        KEY job_id (job_id),
        KEY user_id (user_id),
        KEY status (status)
    ) $charset_collate;";

    // Main Evaluations table
    $sql .= "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}cjm_evaluations (
        evaluation_id bigint(20) NOT NULL AUTO_INCREMENT,
        application_id bigint(20) NOT NULL,
        evaluator_id bigint(20) NOT NULL,
        score decimal(3,2) DEFAULT NULL,
        status varchar(20) NOT NULL DEFAULT 'draft',
        recommendation varchar(50) DEFAULT NULL,
        created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (evaluation_id),
        KEY application_id (application_id),
        KEY evaluator_id (evaluator_id),
        KEY status (status),
        CONSTRAINT fk_evaluation_application 
            FOREIGN KEY (application_id) 
            REFERENCES {$wpdb->prefix}cjm_applications(application_id) 
            ON DELETE CASCADE
    ) $charset_collate;";

    // Applications Meta table
    $sql .= "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}cjm_application_meta (
        meta_id bigint(20) NOT NULL AUTO_INCREMENT,
        application_id bigint(20) NOT NULL,
        meta_key varchar(255) DEFAULT NULL,
        meta_value longtext,
        PRIMARY KEY (meta_id),
        KEY application_id (application_id),
        KEY meta_key (meta_key(191)),
        CONSTRAINT fk_application_meta 
            FOREIGN KEY (application_id) 
            REFERENCES {$wpdb->prefix}cjm_applications(application_id) 
            ON DELETE CASCADE
    ) $charset_collate;";

    // Evaluations Meta table
    $sql .= "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}cjm_evaluation_meta (
        meta_id bigint(20) NOT NULL AUTO_INCREMENT,
        evaluation_id bigint(20) NOT NULL,
        meta_key varchar(255) DEFAULT NULL,
        meta_value longtext,
        PRIMARY KEY (meta_id),
        KEY evaluation_id (evaluation_id),
        KEY meta_key (meta_key(191)),
        CONSTRAINT fk_evaluation_meta 
            FOREIGN KEY (evaluation_id) 
            REFERENCES {$wpdb->prefix}cjm_evaluations(evaluation_id) 
            ON DELETE CASCADE
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    \dbDelta($sql);

    // Log any errors
    if (!empty($wpdb->last_error)) {
        error_log('CJM Plugin Table Creation Error: ' . $wpdb->last_error);
    }
}