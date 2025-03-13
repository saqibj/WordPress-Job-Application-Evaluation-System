<div class="cjm-application-form">
    <?php if (isset($_GET['success'])) : ?>
        <div class="cjm-alert success"><?php _e('Application submitted successfully!'); ?></div>
    <?php else : ?>
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('cjm_application_submit', 'cjm_application_nonce'); ?>
            <input type="hidden" name="job_id" value="<?php echo esc_attr($job_id); ?>">

            <div class="form-group">
                <label><?php _e('Full Name'); ?>*</label>
                <input type="text" name="candidate_name" required>
            </div>

            <div class="form-group">
                <label><?php _e('Email'); ?>*</label>
                <input type="email" name="candidate_email" required>
            </div>

            <div class="form-group">
                <label><?php _e('Resume (PDF/DOCX)'); ?>*</label>
                <input type="file" name="resume" accept=".pdf,.doc,.docx" required>
            </div>

            <div class="form-group recaptcha">
                <?php do_action('cjm_recaptcha_field'); ?>
            </div>

            <button type="submit"><?php _e('Submit Application'); ?></button>
        </form>
    <?php endif; ?>
</div>