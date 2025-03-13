<?php
namespace CJM\PostTypes;

defined('ABSPATH') || exit;

class Evaluations
{
    public function __construct()
    {
        add_action('init', [$this, 'register_post_type']);
        add_action('add_meta_boxes', [$this, 'add_meta_box']);
    }

    public function register_post_type()
    {
        register_post_type('cjm_evaluation', [
            'labels' => [
                'name' => __('Evaluations'),
                'singular_name' => __('Evaluation')
            ],
            'public' => false,
            'show_ui' => true,
            'supports' => ['title', 'custom-fields']
        ]);
    }

    public function add_meta_box()
    {
        add_meta_box(
            'cjm_evaluation_data',
            __('Evaluation Data'),
            [$this, 'render_meta_box'],
            'cjm_evaluation'
        );
    }

    public function render_meta_box($post)
    {
        $data = get_post_meta($post->ID, 'evaluation_data', true);
        echo '<pre>'.print_r($data, true).'</pre>';
    }
}