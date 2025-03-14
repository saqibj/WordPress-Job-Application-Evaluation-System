<?php
defined('ABSPATH') || exit;

$testing_mode = get_option('cjm_testing_mode', 0);

// Check if user is logged in
if (!is_user_logged_in()) {
    ?>
    <div class="cjm-login-required">
        <p>
            <?php echo esc_html__('You must be logged in to submit an application.', 'job-eval-system'); ?>
        </p>
        <p>
            <a href="<?php echo esc_url(site_url('/register')); ?>" class="button">
                <?php echo esc_html__('Register', 'job-eval-system'); ?>
            </a>
            <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="button">
                <?php echo esc_html__('Log In', 'job-eval-system'); ?>
            </a>
        </p>
    </div>
    <style>
    .cjm-login-required {
        text-align: center;
        padding: 40px 20px;
        background: #f8f9fa;
        border-radius: 5px;
    }
    
    .cjm-login-required p {
        margin-bottom: 20px;
    }
    
    .cjm-login-required .button {
        margin: 0 10px;
    }
    </style>
    <?php
    return;
}

// Check if user has applicant role
$user = wp_get_current_user();
if (!in_array('applicant', (array) $user->roles)) {
    ?>
    <div class="notice notice-error">
        <p>
            <?php echo esc_html__('You do not have permission to submit applications.', 'job-eval-system'); ?>
        </p>
    </div>
    <?php
    return;
}
?>

<div class="cjm-application-form">
    <?php if ($testing_mode): ?>
        <div class="notice notice-warning">
            <p>
                <strong><?php echo esc_html__('Testing Mode Active:', 'job-eval-system'); ?></strong>
                <?php echo esc_html__('reCAPTCHA verification is currently disabled.', 'job-eval-system'); ?>
            </p>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <?php wp_nonce_field('cjm_submit_application', 'cjm_application_nonce'); ?>
        
        <!-- Form fields here -->
        
        <?php if (!$testing_mode): ?>
            <div class="g-recaptcha" data-sitekey="<?php echo esc_attr(get_option('cjm_recaptcha_site_key')); ?>"></div>
        <?php endif; ?>
        
        <button type="submit" class="button button-primary">
            <?php echo esc_html__('Submit Application', 'job-eval-system'); ?>
        </button>
    </form>
</div>

<style>
.cjm-application-form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

.notice {
    margin-bottom: 20px;
    padding: 10px 15px;
    border-left: 4px solid #dba617;
    background: #fff;
    box-shadow: 0 1px 1px rgba(0,0,0,.04);
}

.notice-warning {
    border-left-color: #dba617;
}

.notice-error {
    border-left-color: #dc3545;
}

.g-recaptcha {
    margin: 20px 0;
}
</style> 