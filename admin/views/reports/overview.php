<?php
defined('ABSPATH') || exit;

// Get statistics
$total_jobs = wp_count_posts('cjm_job')->publish;
$total_applications = wp_count_posts('cjm_application')->publish;
$total_evaluations = wp_count_posts('cjm_evaluation')->publish;

// Get application status distribution
global $wpdb;
$status_counts = $wpdb->get_results("
    SELECT meta_value as status, COUNT(*) as count 
    FROM {$wpdb->postmeta} 
    WHERE meta_key = 'cjm_status' 
    GROUP BY meta_value
");

// Get monthly application trends
$monthly_trends = $wpdb->get_results("
    SELECT DATE_FORMAT(post_date, '%Y-%m') as month, COUNT(*) as count 
    FROM {$wpdb->posts} 
    WHERE post_type = 'cjm_application' 
    AND post_status = 'publish' 
    GROUP BY month 
    ORDER BY month DESC 
    LIMIT 6
");
?>

<div class="cjm-report-grid">
    <div class="cjm-report-card">
        <h3><?php echo esc_html__('Summary Statistics', 'job-eval-system'); ?></h3>
        <ul class="cjm-stats-list">
            <li>
                <span class="cjm-stat-label"><?php echo esc_html__('Active Jobs', 'job-eval-system'); ?></span>
                <span class="cjm-stat-value"><?php echo esc_html($total_jobs); ?></span>
            </li>
            <li>
                <span class="cjm-stat-label"><?php echo esc_html__('Total Applications', 'job-eval-system'); ?></span>
                <span class="cjm-stat-value"><?php echo esc_html($total_applications); ?></span>
            </li>
            <li>
                <span class="cjm-stat-label"><?php echo esc_html__('Completed Evaluations', 'job-eval-system'); ?></span>
                <span class="cjm-stat-value"><?php echo esc_html($total_evaluations); ?></span>
            </li>
        </ul>
    </div>

    <div class="cjm-report-card">
        <h3><?php echo esc_html__('Application Status Distribution', 'job-eval-system'); ?></h3>
        <div class="cjm-status-chart">
            <?php foreach ($status_counts as $status): ?>
                <div class="cjm-status-bar">
                    <span class="cjm-status-label">
                        <?php echo esc_html(ucfirst($status->status)); ?>
                    </span>
                    <div class="cjm-status-progress">
                        <div class="cjm-status-fill cjm-status-<?php echo esc_attr($status->status); ?>" 
                             style="width: <?php echo esc_attr(($status->count / $total_applications) * 100); ?>%">
                        </div>
                    </div>
                    <span class="cjm-status-count"><?php echo esc_html($status->count); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="cjm-report-card">
    <h3><?php echo esc_html__('Monthly Application Trends', 'job-eval-system'); ?></h3>
    <div class="cjm-trend-chart">
        <?php 
        $max_count = max(array_column($monthly_trends, 'count'));
        foreach ($monthly_trends as $trend): 
        ?>
            <div class="cjm-trend-bar">
                <div class="cjm-trend-fill" 
                     style="height: <?php echo esc_attr(($trend->count / $max_count) * 100); ?>%">
                </div>
                <span class="cjm-trend-count"><?php echo esc_html($trend->count); ?></span>
                <span class="cjm-trend-label">
                    <?php echo esc_html(date_i18n('M Y', strtotime($trend->month))); ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.cjm-stats-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.cjm-stats-list li {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f1;
}

.cjm-stat-value {
    font-weight: bold;
    color: #2271b1;
}

.cjm-status-chart {
    margin-top: 15px;
}

.cjm-status-bar {
    margin: 10px 0;
}

.cjm-status-label {
    display: inline-block;
    width: 100px;
}

.cjm-status-progress {
    display: inline-block;
    width: calc(100% - 160px);
    height: 20px;
    background: #f0f0f1;
    border-radius: 10px;
    margin: 0 10px;
}

.cjm-status-fill {
    height: 100%;
    border-radius: 10px;
    transition: width 0.3s ease;
}

.cjm-status-count {
    display: inline-block;
    width: 40px;
    text-align: right;
}

.cjm-trend-chart {
    display: flex;
    align-items: flex-end;
    height: 200px;
    padding: 20px 0;
    gap: 20px;
}

.cjm-trend-bar {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
}

.cjm-trend-fill {
    width: 40px;
    background: #2271b1;
    border-radius: 4px 4px 0 0;
    transition: height 0.3s ease;
}

.cjm-trend-count {
    margin: 5px 0;
    font-weight: bold;
}

.cjm-trend-label {
    font-size: 12px;
    color: #646970;
}

/* Status Colors */
.cjm-status-new { background: #0a58ca; }
.cjm-status-in_review { background: #997404; }
.cjm-status-archived { background: #495057; }
</style> 