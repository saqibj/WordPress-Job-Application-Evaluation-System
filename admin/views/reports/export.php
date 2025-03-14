<?php
defined('ABSPATH') || exit;

// Handle export requests
if (isset($_POST['cjm_export']) && check_admin_referer('cjm_export_nonce')) {
    $export_type = sanitize_key($_POST['export_type']);
    $date_range = sanitize_key($_POST['date_range']);
    
    // Process export based on type and range
    do_action('cjm_process_export', $export_type, $date_range);
}

// Get export stats
$total_jobs = wp_count_posts('cjm_job')->publish;
$total_applications = wp_count_posts('cjm_application')->publish;
$total_evaluations = wp_count_posts('cjm_evaluation')->publish;
?>

<div class="cjm-export-options">
    <div class="cjm-export-option">
        <h4>
            <?php echo esc_html__('Applications Export', 'job-eval-system'); ?>
            <span class="cjm-export-count">(<?php echo esc_html($total_applications); ?>)</span>
        </h4>
        <form method="post" action="">
            <?php wp_nonce_field('cjm_export_nonce'); ?>
            <input type="hidden" name="export_type" value="applications">
            
            <p>
                <label for="date_range_applications">
                    <?php echo esc_html__('Date Range:', 'job-eval-system'); ?>
                </label>
                <select name="date_range" id="date_range_applications" class="regular-text">
                    <option value="all"><?php echo esc_html__('All Time', 'job-eval-system'); ?></option>
                    <option value="today"><?php echo esc_html__('Today', 'job-eval-system'); ?></option>
                    <option value="week"><?php echo esc_html__('This Week', 'job-eval-system'); ?></option>
                    <option value="month"><?php echo esc_html__('This Month', 'job-eval-system'); ?></option>
                    <option value="year"><?php echo esc_html__('This Year', 'job-eval-system'); ?></option>
                </select>
            </p>

            <p class="submit">
                <input type="submit" 
                       name="cjm_export" 
                       class="button button-primary" 
                       value="<?php echo esc_attr__('Export Applications', 'job-eval-system'); ?>">
            </p>
        </form>
    </div>

    <div class="cjm-export-option">
        <h4>
            <?php echo esc_html__('Evaluations Export', 'job-eval-system'); ?>
            <span class="cjm-export-count">(<?php echo esc_html($total_evaluations); ?>)</span>
        </h4>
        <form method="post" action="">
            <?php wp_nonce_field('cjm_export_nonce'); ?>
            <input type="hidden" name="export_type" value="evaluations">
            
            <p>
                <label for="date_range_evaluations">
                    <?php echo esc_html__('Date Range:', 'job-eval-system'); ?>
                </label>
                <select name="date_range" id="date_range_evaluations" class="regular-text">
                    <option value="all"><?php echo esc_html__('All Time', 'job-eval-system'); ?></option>
                    <option value="today"><?php echo esc_html__('Today', 'job-eval-system'); ?></option>
                    <option value="week"><?php echo esc_html__('This Week', 'job-eval-system'); ?></option>
                    <option value="month"><?php echo esc_html__('This Month', 'job-eval-system'); ?></option>
                    <option value="year"><?php echo esc_html__('This Year', 'job-eval-system'); ?></option>
                </select>
            </p>

            <p class="submit">
                <input type="submit" 
                       name="cjm_export" 
                       class="button button-primary" 
                       value="<?php echo esc_attr__('Export Evaluations', 'job-eval-system'); ?>">
            </p>
        </form>
    </div>

    <div class="cjm-export-option">
        <h4>
            <?php echo esc_html__('Jobs Export', 'job-eval-system'); ?>
            <span class="cjm-export-count">(<?php echo esc_html($total_jobs); ?>)</span>
        </h4>
        <form method="post" action="">
            <?php wp_nonce_field('cjm_export_nonce'); ?>
            <input type="hidden" name="export_type" value="jobs">
            
            <p>
                <label for="date_range_jobs">
                    <?php echo esc_html__('Date Range:', 'job-eval-system'); ?>
                </label>
                <select name="date_range" id="date_range_jobs" class="regular-text">
                    <option value="all"><?php echo esc_html__('All Time', 'job-eval-system'); ?></option>
                    <option value="active"><?php echo esc_html__('Active Only', 'job-eval-system'); ?></option>
                    <option value="month"><?php echo esc_html__('This Month', 'job-eval-system'); ?></option>
                    <option value="year"><?php echo esc_html__('This Year', 'job-eval-system'); ?></option>
                </select>
            </p>

            <p class="submit">
                <input type="submit" 
                       name="cjm_export" 
                       class="button button-primary" 
                       value="<?php echo esc_attr__('Export Jobs', 'job-eval-system'); ?>">
            </p>
        </form>
    </div>
</div>

<style>
.cjm-export-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.cjm-export-option {
    background: #fff;
    padding: 20px;
    border: 1px solid #c3c4c7;
    border-radius: 5px;
}

.cjm-export-option h4 {
    margin-top: 0;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f0f0f1;
}

.cjm-export-count {
    color: #646970;
    font-size: 13px;
    font-weight: normal;
}

.cjm-export-option select {
    width: 100%;
    margin: 5px 0;
}

.cjm-export-option .submit {
    margin: 15px 0 0;
    padding: 0;
}
</style> 