<?php
namespace CJM\Admin;

defined('ABSPATH') || exit;

class Settings
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_settings_page()
    {
        add_submenu_page(
            'edit.php?post_type=cjm_job',
            __('Job System Settings'),
            __('Settings'),
            'manage_options',
            'cjm-settings',
            [$this, 'render_settings_page']
        );
    }

    public function register_settings()
    {
        register_setting('cjm_settings_group', 'cjm_recaptcha_site_key');
        register_setting('cjm_settings_group', 'cjm_recaptcha_secret_key');
        register_setting('cjm_settings_group', 'cjm_resume_size_limit');
        register_setting('cjm_settings_group', 'cjm_data_retention');

        add_settings_section(
            'cjm_general_section',
            __('General Settings'),
            null,
            'cjm-settings'
        );

        $this->add_setting_field('recaptcha_site_key', 'reCAPTCHA Site Key', 'text');
        $this->add_setting_field('recaptcha_secret_key', 'reCAPTCHA Secret Key', 'password');
        $this->add_setting_field('resume_size_limit', 'Max Resume Size (MB)', 'number', 2);
        $this->add_setting_field('data_retention', 'Data Retention Days', 'number', 365);
    }

    private function add_setting_field($name, $title, $type, $default = '')
    {
        add_settings_field(
            'cjm_' . $name,
            __($title),
            [$this, 'render_field'],
            'cjm-settings',
            'cjm_general_section',
            [
                'name' => $name,
                'type' => $type,
                'default' => $default
            ]
        );
    }

    public function render_field($args)
    {
        $value = get_option('cjm_' . $args['name'], $args['default']);
        echo sprintf(
            '<input type="%s" name="cjm_%s" value="%s" class="regular-text">',
            esc_attr($args['type']),
            esc_attr($args['name']),
            esc_attr($value)
        );
    }

    public function render_settings_page()
    {
        ?>
        <div class="wrap">
            <h1><?php _e('Job System Settings') ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('cjm_settings_group');
                do_settings_sections('cjm-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}