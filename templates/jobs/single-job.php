<?php
global $post;
$location = get_post_meta($post->ID, 'cjm_job_location', true);
?>
<article class="cjm-single-job">
    <header class="job-header">
        <h1><?php the_title(); ?></h1>
        <div class="job-meta">
            <?php if ($location) : ?>
                <div class="meta-item">
                    <span class="dashicons dashicons-location"></span>
                    <?php echo esc_html($location); ?>
                </div>
            <?php endif; ?>
            <div class="meta-item">
                <span class="dashicons dashicons-calendar"></span>
                <?php echo get_the_date(); ?>
            </div>
        </div>
    </header>

    <div class="job-content">
        <?php the_content(); ?>
    </div>

    <div class="job-apply">
        <?php echo do_shortcode('[cjm_apply job_id="' . $post->ID . '"]'); ?>
    </div>
</article>