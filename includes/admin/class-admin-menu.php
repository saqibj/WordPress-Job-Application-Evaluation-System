<?php
namespace CJM\Admin;

defined('ABSPATH') || exit;

class AdminMenu {
    private static $instance;

    public static function init() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('admin_menu', [$this, 'register_menus']);
    }

    public function register_menus() {
        // Main Menu
        add_menu_page(
            __('Job Applications', 'job-eval-system'),
            __('Job Applications', 'job-eval-system'),
            'manage_options',
            'job-eval-system',
            [$this, 'render_dashboard'],
            'dashicons-businessperson',
            30
        );

        // Submenus
        add_submenu_page(
            'job-eval-system',
            __('Dashboard', 'job-eval-system'),
            __('Dashboard', 'job-eval-system'),
            'manage_options',
            'job-eval-system',
            [$this, 'render_dashboard']
        );

        add_submenu_page(
            'job-eval-system',
            __('Jobs', 'job-eval-system'),
            __('Jobs', 'job-eval-system'),
            'manage_options',
            'edit.php?post_type=cjm_job'
        );

        add_submenu_page(
            'job-eval-system',
            __('Applications', 'job-eval-system'),
            __('Applications', 'job-eval-system'),
            'manage_options',
            'edit.php?post_type=cjm_application'
        );

        add_submenu_page(
            'job-eval-system',
            __('Evaluations', 'job-eval-system'),
            __('Evaluations', 'job-eval-system'),
            'manage_options',
            'edit.php?post_type=cjm_evaluation'
        );

        add_submenu_page(
            'job-eval-system',
            __('Reports', 'job-eval-system'),
            __('Reports', 'job-eval-system'),
            'manage_options',
            'cjm-reports',
            [$this, 'render_reports']
        );

        add_submenu_page(
            'job-eval-system',
            __('Settings', 'job-eval-system'),
            __('Settings', 'job-eval-system'),
            'manage_options',
            'cjm-settings',
            [$this, 'render_settings']
        );
    }

    public function render_dashboard() {
        require_once CJM_PLUGIN_PATH . 'admin/views/dashboard.php';
    }

    public function render_reports() {
        require_once CJM_PLUGIN_PATH . 'admin/views/reports.php';
    }

    public function render_settings() {
        require_once CJM_PLUGIN_PATH . 'admin/views/settings.php';
    }
} 