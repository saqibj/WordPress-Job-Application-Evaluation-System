<?php
namespace CJM;

defined('ABSPATH') || exit;

class TemplateLoader
{
    public function init()
    {
        add_filter('template_include', [$this, 'load_templates']);
    }

    public function load_templates($template)
    {
        if (is_post_type_archive('cjm_job')) {
            return $this->locate_template('archive-job.php');
        }

        if (is_singular('cjm_job')) {
            return $this->locate_template('single-job.php');
        }

        return $template;
    }

    private function locate_template(string $template)
    {
        $theme_file = get_stylesheet_directory() . '/company-jobs/' . $template;
        
        if (file_exists($theme_file)) {
            return $theme_file;
        }

        return CJM_TEMPLATE_PATH . 'jobs/' . $template;
    }
}