<?php
defined('ABSPATH') || exit;

// Save settings if form is submitted
if (isset($_POST['cjm_save_settings']) && check_admin_referer('cjm_settings_nonce')) {
    // Save existing settings
    update_option('cjm_resume_size_limit', absint($_POST['resume_size_limit']));
    update_option('cjm_data_retention', absint($_POST['data_retention']));
    update_option('cjm_testing_mode', isset($_POST['testing_mode']) ? 1 : 0);
    
    // Handle page creation/update
    if (isset($_POST['create_pages']) && $_POST['create_pages'] === '1') {
        \CJM\Plugin::create_plugin_pages();
        add_settings_error('cjm_settings', 'pages_created', __('Plugin pages have been created successfully.', 'job-eval-system'), 'success');
    }
}

// Get current settings
$resume_size_limit = get_option('cjm_resume_size_limit', 2);
$data_retention = get_option('cjm_data_retention', 365);
$testing_mode = get_option('cjm_testing_mode', 0);

// Get page IDs
$jobs_page_id = get_option('cjm_jobs_page_id');
$apply_page_id = get_option('cjm_apply_page_id');
$dashboard_page_id = get_option('cjm_dashboard_page_id');
$registration_page_id = get_option('cjm_registration_page_id');

?>
<div class="wrap">
    <h1><?php echo esc_html__('Job Applications Settings', 'job-eval-system'); ?></h1>
    
    <?php settings_errors('cjm_settings'); ?>
    
    <form method="post" action="">
        <?php wp_nonce_field('cjm_settings_nonce'); ?>
        
        <h2 class="title"><?php echo esc_html__('General Settings', 'job-eval-system'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="resume_size_limit">
                        <?php echo esc_html__('Resume Size Limit (MB)', 'job-eval-system'); ?>
                    </label>
                </th>
                <td>
                    <input type="number" 
                           id="resume_size_limit" 
                           name="resume_size_limit" 
                           value="<?php echo esc_attr($resume_size_limit); ?>" 
                           min="1" 
                           max="10" 
                           step="1" 
                           class="small-text">
                    <p class="description">
                        <?php echo esc_html__('Maximum allowed size for resume uploads in megabytes.', 'job-eval-system'); ?>
                    </p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="data_retention">
                        <?php echo esc_html__('Data Retention Period (Days)', 'job-eval-system'); ?>
                    </label>
                </th>
                <td>
                    <input type="number" 
                           id="data_retention" 
                           name="data_retention" 
                           value="<?php echo esc_attr($data_retention); ?>" 
                           min="30" 
                           step="1" 
                           class="small-text">
                    <p class="description">
                        <?php echo esc_html__('Number of days to keep application data before automatic cleanup.', 'job-eval-system'); ?>
                    </p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <?php echo esc_html__('Testing Mode', 'job-eval-system'); ?>
                </th>
                <td>
                    <label for="testing_mode">
                        <input type="checkbox" 
                               name="testing_mode" 
                               id="testing_mode"
                               value="1"
                               <?php checked($testing_mode, 1); ?>>
                        <?php echo esc_html__('Enable testing mode (disables reCAPTCHA)', 'job-eval-system'); ?>
                    </label>
                    <p class="description">
                        <?php echo esc_html__('When enabled, reCAPTCHA verification will be disabled for testing purposes. DO NOT enable on production sites!', 'job-eval-system'); ?>
                    </p>
                    <?php if ($testing_mode): ?>
                        <div class="notice notice-warning inline">
                            <p>
                                <strong><?php echo esc_html__('Warning:', 'job-eval-system'); ?></strong>
                                <?php echo esc_html__('Testing mode is enabled. reCAPTCHA verification is currently disabled.', 'job-eval-system'); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <h2 class="title"><?php echo esc_html__('Plugin Pages', 'job-eval-system'); ?></h2>
        <p class="description">
            <?php echo esc_html__('Configure the pages used by the plugin. You can create them automatically or select existing pages.', 'job-eval-system'); ?>
        </p>
        
        <table class="form-table">
            <tr>
                <th scope="row"><?php echo esc_html__('Jobs Page', 'job-eval-system'); ?></th>
                <td>
                    <?php if ($jobs_page_id && get_post($jobs_page_id)): ?>
                        <p>
                            <?php 
                            printf(
                                __('Current page: %s', 'job-eval-system'),
                                '<a href="' . esc_url(get_permalink($jobs_page_id)) . '" target="_blank">' . esc_html(get_the_title($jobs_page_id)) . '</a>'
                            );
                            ?>
                        </p>
                    <?php endif; ?>
                    <input type="text" name="page_title_jobs" value="<?php echo esc_attr__('Job Listings', 'job-eval-system'); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php echo esc_html__('Apply Page', 'job-eval-system'); ?></th>
                <td>
                    <?php if ($apply_page_id && get_post($apply_page_id)): ?>
                        <p>
                            <?php 
                            printf(
                                __('Current page: %s', 'job-eval-system'),
                                '<a href="' . esc_url(get_permalink($apply_page_id)) . '" target="_blank">' . esc_html(get_the_title($apply_page_id)) . '</a>'
                            );
                            ?>
                        </p>
                    <?php endif; ?>
                    <input type="text" name="page_title_apply" value="<?php echo esc_attr__('Apply for Job', 'job-eval-system'); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php echo esc_html__('Dashboard Page', 'job-eval-system'); ?></th>
                <td>
                    <?php if ($dashboard_page_id && get_post($dashboard_page_id)): ?>
                        <p>
                            <?php 
                            printf(
                                __('Current page: %s', 'job-eval-system'),
                                '<a href="' . esc_url(get_permalink($dashboard_page_id)) . '" target="_blank">' . esc_html(get_the_title($dashboard_page_id)) . '</a>'
                            );
                            ?>
                        </p>
                    <?php endif; ?>
                    <input type="text" name="page_title_dashboard" value="<?php echo esc_attr__('Interviewer Dashboard', 'job-eval-system'); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php echo esc_html__('Registration Page', 'job-eval-system'); ?></th>
                <td>
                    <?php if ($registration_page_id && get_post($registration_page_id)): ?>
                        <p>
                            <?php 
                            printf(
                                __('Current page: %s', 'job-eval-system'),
                                '<a href="' . esc_url(get_permalink($registration_page_id)) . '" target="_blank">' . esc_html(get_the_title($registration_page_id)) . '</a>'
                            );
                            ?>
                        </p>
                    <?php endif; ?>
                    <input type="text" name="page_title_registration" value="<?php echo esc_attr__('Applicant Registration', 'job-eval-system'); ?>" class="regular-text">
                </td>
            </tr>
        </table>

        <p>
            <label>
                <input type="checkbox" name="create_pages" value="1">
                <?php echo esc_html__('Create/Update Plugin Pages', 'job-eval-system'); ?>
            </label>
        </p>
        
        <p class="submit">
            <input type="submit" 
                   name="cjm_save_settings" 
                   class="button button-primary" 
                   value="<?php echo esc_attr__('Save Settings', 'job-eval-system'); ?>">
        </p>
    </form>
</div>

<style>
.form-table th {
    width: 250px;
}

.form-table input[type="number"] {
    width: 80px;
}

.description {
    margin-top: 5px;
    color: #646970;
}

.notice.inline {
    margin: 5px 0 0;
    display: inline-block;
}

.form-table select {
    max-width: 400px;
    font-size: 14px;
}

.form-table select option {
    padding: 4px;
}
</style> 