<?php
namespace CJM\Admin;

defined('ABSPATH') || exit;

class AdminMenu {
    public static function init() {
        \add_action('admin_menu', [__CLASS__, 'register_menus']);
    }

    public static function register_menus() {
        // Main Menu
        \add_menu_page(
            \__('Job Applications', 'job-eval-system'),
            \__('Job Applications', 'job-eval-system'),
            'manage_options',
            'job-applications',
            [__CLASS__, 'render_dashboard'],
            'dashicons-businessman',
            25
        );

        // Submenus
        \add_submenu_page(
            'job-applications',
            \__('Dashboard', 'job-eval-system'),
            \__('Dashboard', 'job-eval-system'),
            'manage_options',
            'job-applications',
            [__CLASS__, 'render_dashboard']
        );

        \add_submenu_page(
            'job-applications',
            \__('Jobs', 'job-eval-system'),
            \__('Jobs', 'job-eval-system'),
            'manage_options',
            'edit.php?post_type=job',
            null
        );

        \add_submenu_page(
            'job-applications',
            \__('Applications', 'job-eval-system'),
            \__('Applications', 'job-eval-system'),
            'manage_options',
            'edit.php?post_type=application',
            null
        );

        \add_submenu_page(
            'job-applications',
            \__('Evaluations', 'job-eval-system'),
            \__('Evaluations', 'job-eval-system'),
            'manage_options',
            'edit.php?post_type=evaluation',
            null
        );

        \add_submenu_page(
            'job-applications',
            \__('Reports', 'job-eval-system'),
            \__('Reports', 'job-eval-system'),
            'manage_options',
            'job-applications-reports',
            [__CLASS__, 'render_reports']
        );

        \add_submenu_page(
            'job-applications',
            \__('Settings', 'job-eval-system'),
            \__('Settings', 'job-eval-system'),
            'manage_options',
            'job-applications-settings',
            [__CLASS__, 'render_settings']
        );
    }

    public static function render_dashboard() {
        require_once CJM_PLUGIN_PATH . 'admin/views/dashboard.php';
    }

    public static function render_reports() {
        require_once CJM_PLUGIN_PATH . 'admin/views/reports.php';
    }

    public static function render_settings() {
        require_once CJM_PLUGIN_PATH . 'admin/views/settings.php';
    }
} 