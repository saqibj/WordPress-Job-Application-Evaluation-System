<?php
/**
 * Plugin Name: WordPress Job Application & Evaluation System
 * Plugin URI: https://github.com/saqibj/WordPress-Job-Application-Evaluation-System
 * Description: Comprehensive recruitment management system with job postings, candidate applications, and evaluation workflows.
 * Version: 1.0.0
 * Author: Saqib Jawaid
 * Author URI: https://github.com/saqibj
 * License: GPL-3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: job-eval-system
 */

// Security check
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define core constants
define('CJM_PLUGIN_VERSION', '1.0.0');
define('CJM_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('CJM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CJM_TEMPLATE_PATH', CJM_PLUGIN_PATH . 'templates/');

// Register activation/deactivation hooks
register_activation_hook(__FILE__, 'cjm_activate_plugin');
register_deactivation_hook(__FILE__, 'cjm_deactivate_plugin');

/**
 * Plugin activation handler
 */
function cjm_activate_plugin() {
    require_once CJM_PLUGIN_PATH . 'includes/database/schema.php';
    cjm_create_database_tables();
    
    // Initialize default settings
    update_option('cjm_resume_size_limit', 2); // MB
    update_option('cjm_data_retention', 365); // Days
}

/**
 * Plugin deactivation handler
 */
function cjm_deactivate_plugin() {
    // Clear scheduled tasks
    wp_clear_scheduled_hook('cjm_daily_cleanup');
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