<?php
/**
 * Plugin Name: Job Application & Evaluation System
 * Plugin URI: https://github.com/saqibj/WordPress-Job-Application-Evaluation-System
 * Description: A comprehensive job application and evaluation management system for WordPress.
 * Version: 1.0.4
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Saqib Jawaid
 * Author URI: https://github.com/saqibj
 * License: GPL v3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: job-eval-system
 * Domain Path: /languages
 */

// Security check
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define core constants
define('CJM_PLUGIN_VERSION', '1.0.4');
define('CJM_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('CJM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CJM_TEMPLATE_PATH', CJM_PLUGIN_PATH . 'templates/');
define('CJM_PLUGIN_FILE', __FILE__);

// Register activation/deactivation hooks
register_activation_hook(__FILE__, 'cjm_activate_plugin');
register_deactivation_hook(__FILE__, 'cjm_deactivate_plugin');

/**
 * Create required plugin pages
 */
function cjm_create_plugin_pages() {
    $pages = [
        'cjm_jobs_page' => [
            'title' => __('Jobs', 'job-eval-system'),
            'content' => '[cjm_jobs]'
        ],
        'cjm_applications_page' => [
            'title' => __('My Applications', 'job-eval-system'),
            'content' => '[cjm_my_applications]'
        ],
        'cjm_edit_application_page' => [
            'title' => __('Edit Application', 'job-eval-system'),
            'content' => '[cjm_edit_application]'
        ],
        'cjm_dashboard_page' => [
            'title' => __('Interviewer Dashboard', 'job-eval-system'),
            'content' => '[cjm_dashboard]'
        ],
        'cjm_registration_page' => [
            'title' => __('Register', 'job-eval-system'),
            'content' => '[cjm_registration_form]'
        ]
    ];

    foreach ($pages as $option_name => $page_data) {
        $existing_page_id = get_option($option_name);
        
        // Skip if page already exists
        if ($existing_page_id && get_post($existing_page_id)) {
            continue;
        }

        // Create page
        $page_id = wp_insert_post([
            'post_title' => $page_data['title'],
            'post_content' => $page_data['content'],
            'post_status' => 'publish',
            'post_type' => 'page'
        ]);

        if (!is_wp_error($page_id)) {
            update_option($option_name, $page_id);
        }
    }
}

/**
 * Plugin activation handler
 */
function cjm_activate_plugin() {
    require_once CJM_PLUGIN_PATH . 'includes/database/schema.php';
    cjm_create_database_tables();
    
    // Initialize default settings
    update_option('cjm_resume_size_limit', 2); // MB
    update_option('cjm_data_retention', 365); // Days
    update_option('cjm_testing_mode', 0); // Testing mode disabled by default

    // Create default pages
    cjm_create_plugin_pages();

    // Clear rewrite rules
    flush_rewrite_rules();
}

/**
 * Plugin deactivation handler
 */
function cjm_deactivate_plugin() {
    // Clear scheduled tasks
    wp_clear_scheduled_hook('cjm_daily_cleanup');
    
    // Clear rewrite rules
    flush_rewrite_rules();
    
    // Clean temporary files
    $upload_dir = wp_upload_dir();
    $temp_dir = trailingslashit($upload_dir['basedir']) . 'job-eval-system/temp';
    if (is_dir($temp_dir)) {
        array_map('unlink', glob("$temp_dir/*.*"));
    }
}

// Autoload classes
spl_autoload_register(function ($class_name) {
    $namespace = 'CJM\\';
    
    if (0 !== strpos($class_name, $namespace)) {
        return;
    }
    
    $class_file = str_replace(
        [$namespace, '\\'],
        ['', '/'],
        $class_name
    );
    
    $file_path = CJM_PLUGIN_PATH . 'includes/' . strtolower($class_file) . '.php';
    
    if (file_exists($file_path)) {
        require $file_path;
    }
});

// Initialize plugin
require_once CJM_PLUGIN_PATH . 'includes/class-plugin.php';
CJM\Plugin::instance()->run();