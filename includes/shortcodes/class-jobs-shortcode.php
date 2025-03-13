<?php
namespace CJM\Shortcodes;

defined('ABSPATH') || exit;

class JobsShortcode
{
    public function __construct()
    {
        add_shortcode('cjm_jobs', [$this, 'render']);
    }

    public function render($atts)
    {
        $atts = shortcode_atts([
            'per_page' => 10,
            'order' => 'DESC'
        ], $atts);

        ob_start();
        
        $query = new \WP_Query([
            'post_type' => 'cjm_job',
            'posts_per_page' => $atts['per_page'],
            'order' => $atts['order']
        ]);

        if ($query->have_posts()) {
            echo '<div class="cjm-jobs-list">';
            while ($query->have_posts()) {
                $query->the_post();
                include CJM_TEMPLATE_PATH . 'jobs/archive-job.php';
            }
            echo '</div>';
        } else {
            echo '<p>'.__('No open positions available').'</p>';
        }

        wp_reset_postdata();
        return ob_get_clean();
    }
}