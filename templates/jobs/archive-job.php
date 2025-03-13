<article class="cjm-job-listing">
    <header class="job-header">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="job-meta">
            <span class="location"><?php echo esc_html(get_post_meta(get_the_ID(), 'cjm_job_location', true)); ?></span>
            <span class="date"><?php echo get_the_date(); ?></span>
        </div>
    </header>
    
    <div class="job-content">
        <?php the_excerpt(); ?>
    </div>
    
    <footer class="job-footer">
        <a href="<?php the_permalink(); ?>" class="button">
            <?php _e('View Details & Apply'); ?>
        </a>
    </footer>
</article>