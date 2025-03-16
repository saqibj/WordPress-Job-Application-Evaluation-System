<?php
defined('ABSPATH') || exit;

$testing_mode = get_option('cjm_testing_mode', 0);

// Check if user is logged in
if (!is_user_logged_in()) {
    ?>
    <div class="cjm-login-required">
        <p><?php echo esc_html__('You must be logged in to submit an application.', 'job-eval-system'); ?></p>
        <p>
            <a href="<?php echo esc_url(site_url('/register')); ?>" class="button">
                <?php echo esc_html__('Register', 'job-eval-system'); ?>
            </a>
            <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="button">
                <?php echo esc_html__('Log In', 'job-eval-system'); ?>
            </a>
        </p>
    </div>
    <?php
    return;
}

// Get current user data
$current_user = wp_get_current_user();
?>

<div class="cjm-application-form">
    <?php if (isset($_GET['success'])) : ?>
        <div class="cjm-alert success">
            <?php _e('Application submitted successfully!', 'job-eval-system'); ?>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" id="jobApplicationForm">
        <?php wp_nonce_field('cjm_application_submit', 'cjm_application_nonce'); ?>
        <input type="hidden" name="job_id" value="<?php echo esc_attr($job_id); ?>">

        <!-- 1. Personal Information -->
        <h3><?php _e('Personal Information', 'job-eval-system'); ?></h3>
        <div class="form-group">
            <label for="candidate_name"><?php _e('Full Name', 'job-eval-system'); ?>*</label>
            <input type="text" 
                   id="candidate_name" 
                   name="candidate_name" 
                   value="<?php echo esc_attr($current_user->display_name); ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="dob"><?php _e('Date of Birth', 'job-eval-system'); ?></label>
            <input type="date" id="dob" name="dob">
        </div>

        <div class="form-group">
            <label for="citizenship"><?php _e('Are you legally authorized to work?', 'job-eval-system'); ?>*</label>
            <select id="citizenship" name="citizenship" required>
                <option value=""><?php _e('Select', 'job-eval-system'); ?></option>
                <option value="yes"><?php _e('Yes', 'job-eval-system'); ?></option>
                <option value="no"><?php _e('No', 'job-eval-system'); ?></option>
            </select>
        </div>

        <!-- 2. Contact Details -->
        <h3><?php _e('Contact Details', 'job-eval-system'); ?></h3>
        <div class="form-group">
            <label for="candidate_email"><?php _e('Email', 'job-eval-system'); ?>*</label>
            <input type="email" 
                   id="candidate_email" 
                   name="candidate_email" 
                   value="<?php echo esc_attr($current_user->user_email); ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="phone"><?php _e('Phone Number', 'job-eval-system'); ?>*</label>
            <input type="tel" 
                   id="phone" 
                   name="phone" 
                   value="<?php echo esc_attr(get_user_meta($current_user->ID, 'phone_number', true)); ?>"
                   required>
            <p class="description"><?php _e('Please include country code (e.g., +1 for US/Canada)', 'job-eval-system'); ?></p>
        </div>

        <div class="form-group">
            <label for="linkedin"><?php _e('LinkedIn/Portfolio URL', 'job-eval-system'); ?></label>
            <input type="url" id="linkedin" name="linkedin">
        </div>

        <!-- 3. Education History -->
        <h3><?php _e('Education History', 'job-eval-system'); ?>*</h3>
        <div class="form-group">
            <label for="degree"><?php _e('Highest Degree', 'job-eval-system'); ?>*</label>
            <select id="degree" name="degree" required>
                <option value=""><?php _e('Select', 'job-eval-system'); ?></option>
                <option value="highschool"><?php _e('High School', 'job-eval-system'); ?></option>
                <option value="bachelor"><?php _e('Bachelor\'s', 'job-eval-system'); ?></option>
                <option value="master"><?php _e('Master\'s', 'job-eval-system'); ?></option>
                <option value="phd"><?php _e('PhD', 'job-eval-system'); ?></option>
            </select>
        </div>

        <div class="form-group">
            <label for="institution"><?php _e('Institution Name', 'job-eval-system'); ?>*</label>
            <input type="text" id="institution" name="institution" required>
        </div>

        <!-- 4. Work Experience -->
        <h3><?php _e('Work Experience', 'job-eval-system'); ?></h3>
        <div class="form-group">
            <label for="employmentType"><?php _e('Employment Type', 'job-eval-system'); ?></label>
            <select id="employmentType" name="employmentType">
                <option value=""><?php _e('Select', 'job-eval-system'); ?></option>
                <option value="fulltime"><?php _e('Full-Time', 'job-eval-system'); ?></option>
                <option value="parttime"><?php _e('Part-Time', 'job-eval-system'); ?></option>
                <option value="contract"><?php _e('Contract', 'job-eval-system'); ?></option>
            </select>
        </div>

        <div class="form-group">
            <label><?php _e('Previous Jobs', 'job-eval-system'); ?></label>
            <div id="previous-jobs">
                <div class="job-entry">
                    <input type="text" name="jobs[0][company]" placeholder="<?php esc_attr_e('Company Name', 'job-eval-system'); ?>">
                    <input type="text" name="jobs[0][title]" placeholder="<?php esc_attr_e('Job Title', 'job-eval-system'); ?>">
                    <input type="date" name="jobs[0][start_date]" placeholder="<?php esc_attr_e('Start Date', 'job-eval-system'); ?>">
                    <button type="button" class="remove-job button-secondary"><?php _e('Remove', 'job-eval-system'); ?></button>
                </div>
            </div>
            <button type="button" id="add-job" class="button-secondary">
                <?php _e('Add Another Job', 'job-eval-system'); ?>
            </button>
        </div>

        <!-- 5. Skills & Qualifications -->
        <h3><?php _e('Skills & Qualifications', 'job-eval-system'); ?></h3>
        <div class="form-group">
            <label><?php _e('Technical Skills', 'job-eval-system'); ?>*</label>
            <div class="skills-grid">
                <?php
                $skills = [
                    'Python' => __('Python', 'job-eval-system'),
                    'Java' => __('Java', 'job-eval-system'),
                    'JavaScript' => __('JavaScript', 'job-eval-system'),
                    'PHP' => __('PHP', 'job-eval-system'),
                    'SQL' => __('SQL', 'job-eval-system'),
                    'Excel' => __('Excel', 'job-eval-system'),
                    'ProjectMgmt' => __('Project Management', 'job-eval-system'),
                    'Agile' => __('Agile', 'job-eval-system'),
                ];
                foreach ($skills as $value => $label) : ?>
                    <div class="skill-item">
                        <input type="checkbox" 
                               id="skill_<?php echo esc_attr($value); ?>" 
                               name="skills[]" 
                               value="<?php echo esc_attr($value); ?>">
                        <label for="skill_<?php echo esc_attr($value); ?>">
                            <?php echo esc_html($label); ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="language"><?php _e('Language Proficiency', 'job-eval-system'); ?>*</label>
            <select id="language" name="language" required>
                <option value=""><?php _e('Select', 'job-eval-system'); ?></option>
                <option value="english"><?php _e('English (Fluent)', 'job-eval-system'); ?></option>
                <option value="spanish"><?php _e('Spanish (Intermediate)', 'job-eval-system'); ?></option>
                <option value="other"><?php _e('Other', 'job-eval-system'); ?></option>
            </select>
        </div>

        <!-- 6. Attachments -->
        <h3><?php _e('Attachments', 'job-eval-system'); ?></h3>
        <div class="form-group">
            <label for="resume"><?php _e('Resume/CV', 'job-eval-system'); ?>*</label>
            <input type="file" 
                   id="resume" 
                   name="resume" 
                   accept=".pdf,.doc,.docx" 
                   required>
            <p class="description">
                <?php printf(
                    __('Accepted formats: PDF, DOC, DOCX. Maximum size: %sMB', 'job-eval-system'),
                    esc_html(get_option('cjm_resume_size_limit', 2))
                ); ?>
            </p>
        </div>

        <div class="form-group">
            <label for="coverLetter"><?php _e('Cover Letter', 'job-eval-system'); ?></label>
            <input type="file" 
                   id="coverLetter" 
                   name="coverLetter" 
                   accept=".pdf,.doc,.docx">
        </div>

        <!-- 7. Legal & Compliance -->
        <h3><?php _e('Legal & Compliance', 'job-eval-system'); ?></h3>
        <div class="form-group checkbox-group">
            <input type="checkbox" id="consent" name="consent" required>
            <label for="consent"><?php _e('I consent to a background check', 'job-eval-system'); ?>*</label>
        </div>

        <div class="form-group">
            <label for="eeo"><?php _e('EEO Self-Identification (Optional)', 'job-eval-system'); ?></label>
            <select id="eeo" name="eeo">
                <option value=""><?php _e('Prefer not to say', 'job-eval-system'); ?></option>
                <option value="female"><?php _e('Female', 'job-eval-system'); ?></option>
                <option value="male"><?php _e('Male', 'job-eval-system'); ?></option>
                <option value="nonbinary"><?php _e('Non-Binary', 'job-eval-system'); ?></option>
            </select>
        </div>

        <!-- 8. Signature -->
        <div class="form-group">
            <label for="signature"><?php _e('Electronic Signature', 'job-eval-system'); ?>*</label>
            <input type="text" 
                   id="signature" 
                   name="signature" 
                   placeholder="<?php esc_attr_e('Type Full Name', 'job-eval-system'); ?>" 
                   required>
        </div>

        <div class="form-group checkbox-group">
            <input type="checkbox" id="certify" name="certify" required>
            <label for="certify"><?php _e('I certify that the information provided is accurate', 'job-eval-system'); ?>*</label>
        </div>

        <?php if (!$testing_mode): ?>
            <div class="form-group recaptcha">
                <?php do_action('cjm_recaptcha_field'); ?>
            </div>
        <?php endif; ?>

        <button type="submit" class="button button-primary">
            <?php _e('Submit Application', 'job-eval-system'); ?>
        </button>
    </form>
</div>

<style>
.cjm-application-form {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.form-group label:after {
    content: " *";
    color: #dc3545;
}

.form-group label:not([for*="required"]):after {
    content: "";
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="tel"],
.form-group input[type="url"],
.form-group input[type="date"],
.form-group select {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.checkbox-group {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.checkbox-group label {
    margin-bottom: 0;
}

.checkbox-group input[type="checkbox"] {
    margin: 0;
}

.skills-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 0.5rem;
}

.skill-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.job-entry {
    display: grid;
    grid-template-columns: repeat(3, 1fr) auto;
    gap: 1rem;
    margin-bottom: 1rem;
    align-items: start;
}

.description {
    font-size: 0.9em;
    color: #666;
    margin-top: 0.5rem;
}

h3 {
    margin: 2rem 0 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #eee;
}

.button {
    display: inline-block;
    padding: 0.8rem 1.5rem;
    background: #2271b1;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
}

.button-secondary {
    background: #f8f9fa;
    color: #2271b1;
    border: 1px solid #2271b1;
}

.button:hover {
    opacity: 0.9;
}

.cjm-alert {
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1rem;
}

.success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
.error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
</style>