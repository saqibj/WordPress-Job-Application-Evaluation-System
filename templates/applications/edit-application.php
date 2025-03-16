<?php
defined('ABSPATH') || exit;

$application_id = get_query_var('application_id');
$application = get_post($application_id);

// Security checks
if (!$application || $application->post_type !== 'cjm_application' || 
    !current_user_can('edit_application', $application_id) || 
    get_current_user_id() != $application->post_author) {
    wp_die(__('You do not have permission to edit this application.', 'job-eval-system'));
}

$job_id = get_post_meta($application_id, 'cjm_job_id', true);
$candidate_name = get_post_meta($application_id, 'cjm_candidate_name', true);
$candidate_email = get_post_meta($application_id, 'cjm_candidate_email', true);
$phone = get_post_meta($application_id, 'cjm_phone', true);
$resume_url = get_post_meta($application_id, 'cjm_resume_path', true);
?>

<div class="cjm-application-form edit-mode">
    <?php if (isset($_GET['updated'])): ?>
        <div class="cjm-alert success">
            <?php _e('Application updated successfully!', 'job-eval-system'); ?>
        </div>
    <?php endif; ?>

    <h2><?php _e('Edit Application', 'job-eval-system'); ?></h2>
    
    <form method="post" enctype="multipart/form-data">
        <?php wp_nonce_field('cjm_edit_application', 'cjm_edit_application_nonce'); ?>
        <input type="hidden" name="application_id" value="<?php echo esc_attr($application_id); ?>">
        <input type="hidden" name="action" value="cjm_edit_application">

        <div class="form-group">
            <label><?php _e('Job Position', 'job-eval-system'); ?></label>
            <div class="field-value"><?php echo esc_html(get_the_title($job_id)); ?></div>
        </div>

        <div class="form-group">
            <label for="candidate_name"><?php _e('Full Name', 'job-eval-system'); ?>*</label>
            <input type="text" 
                   id="candidate_name" 
                   name="candidate_name" 
                   value="<?php echo esc_attr($candidate_name); ?>" 
                   required>
        </div>

        <div class="form-group">
            <label for="candidate_email"><?php _e('Email', 'job-eval-system'); ?>*</label>
            <input type="email" 
                   id="candidate_email" 
                   name="candidate_email" 
                   value="<?php echo esc_attr($candidate_email); ?>" 
                   required>
        </div>

        <div class="form-group">
            <label for="phone"><?php _e('Phone Number', 'job-eval-system'); ?>*</label>
            <input type="tel" 
                   id="phone" 
                   name="phone" 
                   value="<?php echo esc_attr($phone); ?>" 
                   required>
            <p class="description"><?php _e('Please include country code (e.g., +1 for US/Canada)', 'job-eval-system'); ?></p>
        </div>

        <div class="form-group">
            <label><?php _e('Current Resume', 'job-eval-system'); ?></label>
            <?php if ($resume_url): ?>
                <div class="current-resume">
                    <a href="<?php echo esc_url($resume_url); ?>" target="_blank">
                        <?php _e('View Current Resume', 'job-eval-system'); ?>
                    </a>
                </div>
            <?php endif; ?>
            
            <label for="new_resume"><?php _e('Upload New Resume (optional)', 'job-eval-system'); ?></label>
            <input type="file" 
                   id="new_resume" 
                   name="new_resume" 
                   accept=".pdf,.doc,.docx">
            <p class="description">
                <?php printf(
                    __('Accepted formats: PDF, DOC, DOCX. Maximum size: %sMB', 'job-eval-system'),
                    esc_html(get_option('cjm_resume_size_limit', 2))
                ); ?>
            </p>
        </div>

        <div class="form-actions">
            <button type="submit" class="button button-primary">
                <?php _e('Update Application', 'job-eval-system'); ?>
            </button>
            <a href="<?php echo esc_url(get_permalink(get_option('cjm_applications_page'))); ?>" class="button">
                <?php _e('Cancel', 'job-eval-system'); ?>
            </a>
        </div>
    </form>
</div>

<style>
.cjm-application-form.edit-mode {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.field-value {
    padding: 0.8rem;
    background: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.current-resume {
    margin-bottom: 1rem;
}

.form-actions {
    margin-top: 2rem;
    display: flex;
    gap: 1rem;
}

.description {
    font-size: 0.9em;
    color: #666;
    margin-top: 0.5rem;
}
</style> 