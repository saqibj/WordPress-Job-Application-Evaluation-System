<?php
namespace CJM\Admin;

defined('ABSPATH') || exit;

class Applications_List extends \WP_List_Table
{
    public function __construct()
    {
        parent::__construct([
            'singular' => 'application',
            'plural' => 'applications',
            'ajax' => false
        ]);
    }

    public function get_columns()
    {
        return [
            'cb' => '<input type="checkbox">',
            'candidate_name' => __('Candidate'),
            'job_title' => __('Position'),
            'status' => __('Status'),
            'date' => __('Date')
        ];
    }

    public function prepare_items()
    {
        $this->_column_headers = [$this->get_columns()];
        $per_page = $this->get_items_per_page('applications_per_page', 20);
        
        $db = new \CJM\Database\Applications();
        $this->items = $db->get_applications([
            'per_page' => $per_page,
            'page' => $this->get_pagenum()
        ]);
        
        $this->set_pagination_args([
            'total_items' => $db->get_total(),
            'per_page' => $per_page
        ]);
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'candidate_name':
                return '<a href="mailto:'.esc_attr($item->candidate_email).'">'
                      . esc_html($item->candidate_name) . '</a>';
            case 'job_title':
                return '<a href="'.get_edit_post_link($item->job_id).'">'
                      . get_the_title($item->job_id) . '</a>';
            case 'status':
                return '<span class="status-'.$item->status.'">'
                      . ucfirst($item->status).'</span>';
            default:
                return $item->$column_name;
        }
    }

    public function get_bulk_actions()
    {
        return [
            'archive' => __('Archive'),
            'delete' => __('Delete Permanently')
        ];
    }
}