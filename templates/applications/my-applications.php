<?php
defined('ABSPATH') || exit;

if (!is_user_logged_in()) {
    ?>
    <div class="cjm-login-required">
        <p><?php echo esc_html__('You must be logged in to view your applications.', 'job-eval-system'); ?></p>
        <p>
            <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="button">
                <?php echo esc_html__('Log In', 'job-eval-system'); ?>
            </a>
        </p>
    </div>
    <?php
    return;
}

$current_user = wp_get_current_user();
$args = [
    'post_type' => 'cjm_application',
    'author' => $current_user->ID,
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC'
];

$applications = new WP_Query($args);
?>

<div class="cjm-my-applications">
    <h2><?php echo esc_html__('My Applications', 'job-eval-system'); ?></h2>

    <?php if ($applications->have_posts()): ?>
        <div class="applications-list">
            <?php while ($applications->have_posts()): $applications->the_post(); 
                $job_id = get_post_meta(get_the_ID(), 'cjm_job_id', true);
                $status = get_post_meta(get_the_ID(), 'cjm_status', true);
                $last_edited = get_post_meta(get_the_ID(), 'cjm_last_edited', true);
            ?>
                <div class="application-item">
                    <div class="application-header">
                        <h3><?php echo esc_html(get_the_title($job_id)); ?></h3>
                        <span class="status status-<?php echo esc_attr($status); ?>">
                            <?php echo esc_html(ucfirst($status)); ?>
                        </span>
                    </div>
                    
                    <div class="application-meta">
                        <span class="date">
                            <?php echo esc_html__('Applied:', 'job-eval-system'); ?> 
                            <?php echo esc_html(get_the_date()); ?>
                        </span>
                        <?php if ($last_edited): ?>
                            <span class="edited">
                                <?php echo esc_html__('Last edited:', 'job-eval-system'); ?> 
                                <?php echo esc_html(date_i18n(get_option('date_format'), strtotime($last_edited))); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="application-actions">
                        <a href="<?php echo esc_url(add_query_arg(['application_id' => get_the_ID()], get_permalink(get_option('cjm_edit_application_page')))); ?>" 
                           class="button">
                            <?php echo esc_html__('Edit Application', 'job-eval-system'); ?>
                        </a>
                        <a href="<?php echo esc_url(get_permalink($job_id)); ?>" 
                           class="button button-secondary">
                            <?php echo esc_html__('View Job', 'job-eval-system'); ?>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="no-applications">
            <p><?php echo esc_html__('You haven\'t submitted any applications yet.', 'job-eval-system'); ?></p>
            <p>
                <a href="<?php echo esc_url(get_post_type_archive_link('cjm_job')); ?>" class="button">
                    <?php echo esc_html__('Browse Jobs', 'job-eval-system'); ?>
                </a>
            </p>
        </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</div>

<style>
.cjm-my-applications {
    max-width: 800px;
    margin: 2rem auto;
}

.application-item {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.application-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.application-header h3 {
    margin: 0;
    font-size: 1.2rem;
}

.status {
    padding: 0.3rem 0.8rem;
    border-radius: 3px;
    font-size: 0.9rem;
    font-weight: 500;
}

.status-new { background: #e3f2fd; color: #1976d2; }
.status-in_review { background: #fff3e0; color: #f57c00; }
.status-accepted { background: #e8f5e9; color: #388e3c; }
.status-rejected { background: #ffebee; color: #d32f2f; }

.application-meta {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.application-meta span {
    margin-right: 1.5rem;
}

.application-actions {
    display: flex;
    gap: 1rem;
}

.no-applications {
    text-align: center;
    padding: 3rem 1rem;
    background: #f8f9fa;
    border-radius: 4px;
}

.button {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: #2271b1;
    color: white;
    text-decoration: none;
    border-radius: 3px;
    border: none;
    cursor: pointer;
}

.button-secondary {
    background: #f8f9fa;
    color: #2271b1;
    border: 1px solid #2271b1;
}

.button:hover {
    opacity: 0.9;
}
</style> 