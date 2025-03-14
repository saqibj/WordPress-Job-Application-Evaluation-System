<?php
defined('ABSPATH') || exit;

// Get evaluation statistics
global $wpdb;
$evaluation_stats = $wpdb->get_row("
    SELECT 
        AVG(CAST(meta_value AS DECIMAL(10,2))) as avg_score,
        MIN(CAST(meta_value AS DECIMAL(10,2))) as min_score,
        MAX(CAST(meta_value AS DECIMAL(10,2))) as max_score
    FROM {$wpdb->postmeta}
    WHERE meta_key = 'cjm_evaluation_score'
");

// Get evaluations by criterion
$criterion_stats = $wpdb->get_results("
    SELECT 
        meta_value as criterion,
        COUNT(*) as count,
        AVG(CAST(pm2.meta_value AS DECIMAL(10,2))) as avg_score
    FROM {$wpdb->postmeta} pm1
    JOIN {$wpdb->postmeta} pm2 ON pm1.post_id = pm2.post_id
    WHERE pm1.meta_key = 'cjm_criterion'
    AND pm2.meta_key = 'cjm_score'
    GROUP BY pm1.meta_value
    ORDER BY avg_score DESC
");

// Get recent evaluations
$recent_evaluations = get_posts([
    'post_type' => 'cjm_evaluation',
    'posts_per_page' => 10,
    'orderby' => 'date',
    'order' => 'DESC'
]);
?>

<div class="cjm-report-grid">
    <div class="cjm-report-card">
        <h3><?php echo esc_html__('Evaluation Scores Overview', 'job-eval-system'); ?></h3>
        <div class="cjm-score-overview">
            <div class="cjm-score-stat">
                <span class="cjm-score-label"><?php echo esc_html__('Average Score', 'job-eval-system'); ?></span>
                <span class="cjm-score-value"><?php echo esc_html(number_format($evaluation_stats->avg_score, 1)); ?></span>
            </div>
            <div class="cjm-score-stat">
                <span class="cjm-score-label"><?php echo esc_html__('Highest Score', 'job-eval-system'); ?></span>
                <span class="cjm-score-value"><?php echo esc_html(number_format($evaluation_stats->max_score, 1)); ?></span>
            </div>
            <div class="cjm-score-stat">
                <span class="cjm-score-label"><?php echo esc_html__('Lowest Score', 'job-eval-system'); ?></span>
                <span class="cjm-score-value"><?php echo esc_html(number_format($evaluation_stats->min_score, 1)); ?></span>
            </div>
        </div>
    </div>

    <div class="cjm-report-card">
        <h3><?php echo esc_html__('Performance by Criterion', 'job-eval-system'); ?></h3>
        <div class="cjm-criterion-chart">
            <?php foreach ($criterion_stats as $criterion): ?>
                <div class="cjm-criterion-bar">
                    <span class="cjm-criterion-label">
                        <?php echo esc_html($criterion->criterion); ?>
                        <small>(<?php echo esc_html($criterion->count); ?>)</small>
                    </span>
                    <div class="cjm-criterion-progress">
                        <div class="cjm-criterion-fill" 
                             style="width: <?php echo esc_attr(($criterion->avg_score / 5) * 100); ?>%">
                            <?php echo esc_html(number_format($criterion->avg_score, 1)); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="cjm-report-card">
    <h3><?php echo esc_html__('Recent Evaluations', 'job-eval-system'); ?></h3>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th><?php echo esc_html__('Candidate', 'job-eval-system'); ?></th>
                <th><?php echo esc_html__('Job', 'job-eval-system'); ?></th>
                <th><?php echo esc_html__('Evaluator', 'job-eval-system'); ?></th>
                <th><?php echo esc_html__('Score', 'job-eval-system'); ?></th>
                <th><?php echo esc_html__('Date', 'job-eval-system'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recent_evaluations as $evaluation): 
                $application_id = get_post_meta($evaluation->ID, 'cjm_application_id', true);
                $evaluator_id = get_post_meta($evaluation->ID, 'cjm_evaluator_id', true);
                $score = get_post_meta($evaluation->ID, 'cjm_evaluation_score', true);
                $job_id = get_post_meta($application_id, 'cjm_job_id', true);
            ?>
                <tr>
                    <td>
                        <a href="<?php echo esc_url(get_edit_post_link($application_id)); ?>">
                            <?php echo esc_html(get_post_meta($application_id, 'cjm_candidate_name', true)); ?>
                        </a>
                    </td>
                    <td><?php echo esc_html(get_the_title($job_id)); ?></td>
                    <td><?php echo esc_html(get_the_author_meta('display_name', $evaluator_id)); ?></td>
                    <td>
                        <span class="cjm-score-badge">
                            <?php echo esc_html(number_format($score, 1)); ?>
                        </span>
                    </td>
                    <td><?php echo esc_html(get_the_date('', $evaluation->ID)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
.cjm-score-overview {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    text-align: center;
    margin-top: 15px;
}

.cjm-score-stat {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 5px;
}

.cjm-score-label {
    display: block;
    color: #646970;
    margin-bottom: 5px;
}

.cjm-score-value {
    display: block;
    font-size: 24px;
    font-weight: bold;
    color: #2271b1;
}

.cjm-criterion-chart {
    margin-top: 15px;
}

.cjm-criterion-bar {
    margin: 10px 0;
}

.cjm-criterion-label {
    display: block;
    margin-bottom: 5px;
}

.cjm-criterion-label small {
    color: #646970;
}

.cjm-criterion-progress {
    height: 25px;
    background: #f0f0f1;
    border-radius: 12.5px;
}

.cjm-criterion-fill {
    height: 100%;
    background: #2271b1;
    border-radius: 12.5px;
    color: #fff;
    text-align: right;
    padding: 0 10px;
    line-height: 25px;
    transition: width 0.3s ease;
}

.cjm-score-badge {
    display: inline-block;
    padding: 3px 8px;
    background: #e7f5ff;
    color: #0a58ca;
    border-radius: 3px;
    font-weight: 500;
}
</style> 