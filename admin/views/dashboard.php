<?php
defined('ABSPATH') || exit;

$total_jobs = wp_count_posts('cjm_job')->publish;
$total_applications = wp_count_posts('cjm_application')->publish;
$recent_applications = get_posts([
    'post_type' => 'cjm_application',
    'posts_per_page' => 5,
    'orderby' => 'date',
    'order' => 'DESC'
]);
?>

<div class="wrap">
    <h1><?php echo esc_html__('Job Applications Dashboard', 'job-eval-system'); ?></h1>

    <div class="cjm-dashboard-stats">
        <div class="cjm-stat-box">
            <h3><?php echo esc_html__('Active Jobs', 'job-eval-system'); ?></h3>
            <span class="cjm-stat-number"><?php echo esc_html($total_jobs); ?></span>
            <a href="<?php echo esc_url(admin_url('edit.php?post_type=cjm_job')); ?>" class="button">
                <?php echo esc_html__('View All', 'job-eval-system'); ?>
            </a>
        </div>

        <div class="cjm-stat-box">
            <h3><?php echo esc_html__('Total Applications', 'job-eval-system'); ?></h3>
            <span class="cjm-stat-number"><?php echo esc_html($total_applications); ?></span>
            <a href="<?php echo esc_url(admin_url('edit.php?post_type=cjm_application')); ?>" class="button">
                <?php echo esc_html__('View All', 'job-eval-system'); ?>
            </a>
        </div>
    </div>

    <div class="cjm-recent-applications">
        <h2><?php echo esc_html__('Recent Applications', 'job-eval-system'); ?></h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php echo esc_html__('Candidate', 'job-eval-system'); ?></th>
                    <th><?php echo esc_html__('Job', 'job-eval-system'); ?></th>
                    <th><?php echo esc_html__('Date', 'job-eval-system'); ?></th>
                    <th><?php echo esc_html__('Status', 'job-eval-system'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_applications as $application): ?>
                    <?php
                    $job_id = get_post_meta($application->ID, 'cjm_job_id', true);
                    $job_title = get_the_title($job_id);
                    $status = get_post_meta($application->ID, 'cjm_status', true);
                    ?>
                    <tr>
                        <td>
                            <a href="<?php echo esc_url(get_edit_post_link($application->ID)); ?>">
                                <?php echo esc_html(get_post_meta($application->ID, 'cjm_candidate_name', true)); ?>
                            </a>
                        </td>
                        <td><?php echo esc_html($job_title); ?></td>
                        <td><?php echo esc_html(get_the_date('', $application->ID)); ?></td>
                        <td><span class="cjm-status cjm-status-<?php echo esc_attr($status); ?>">
                            <?php echo esc_html(ucfirst($status)); ?>
                        </span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="cjm-quick-links">
        <h2><?php echo esc_html__('Quick Links', 'job-eval-system'); ?></h2>
        <div class="cjm-quick-links-grid">
            <a href="<?php echo esc_url(admin_url('post-new.php?post_type=cjm_job')); ?>" class="cjm-quick-link">
                <span class="dashicons dashicons-plus"></span>
                <?php echo esc_html__('Add New Job', 'job-eval-system'); ?>
            </a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=cjm-reports')); ?>" class="cjm-quick-link">
                <span class="dashicons dashicons-chart-bar"></span>
                <?php echo esc_html__('View Reports', 'job-eval-system'); ?>
            </a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=cjm-settings')); ?>" class="cjm-quick-link">
                <span class="dashicons dashicons-admin-settings"></span>
                <?php echo esc_html__('Settings', 'job-eval-system'); ?>
            </a>
        </div>
    </div>
</div>

<style>
.cjm-dashboard-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.cjm-stat-box {
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    text-align: center;
}

.cjm-stat-number {
    display: block;
    font-size: 2em;
    font-weight: bold;
    margin: 10px 0;
    color: #2271b1;
}

.cjm-quick-links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.cjm-quick-link {
    display: flex;
    align-items: center;
    padding: 15px;
    background: #fff;
    border-radius: 5px;
    text-decoration: none;
    color: #1d2327;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
}

.cjm-quick-link:hover {
    background: #f0f0f1;
    color: #2271b1;
}

.cjm-quick-link .dashicons {
    margin-right: 10px;
    color: #2271b1;
}

.cjm-status {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 12px;
    font-weight: 500;
}

.cjm-status-new { background: #e7f5ff; color: #0a58ca; }
.cjm-status-in_review { background: #fff3cd; color: #997404; }
.cjm-status-archived { background: #f8f9fa; color: #495057; }
</style> 