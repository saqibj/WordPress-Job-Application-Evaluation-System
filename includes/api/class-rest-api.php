<?php
namespace CJM\Api;

defined('ABSPATH') || exit;

class RestAPI
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes()
    {
        register_rest_route('cjm/v1', '/applications', [
            'methods' => 'GET',
            'callback' => [$this, 'get_applications'],
            'permission_callback' => [$this, 'check_admin_permissions']
        ]);

        register_rest_route('cjm/v1', '/evaluations/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => [$this, 'get_evaluation_report'],
            'args' => ['id' => ['validate_callback' => 'absint']]
        ]);
    }

    public function get_applications(\WP_REST_Request $request)
    {
        $db = new \CJM\Database\Applications();
        return $db->get_applications($request->get_params());
    }

    public function get_evaluation_report(\WP_REST_Request $request)
    {
        $scoring = new \CJM\Evaluations\Scoring();
        return [
            'average' => $scoring->calculate_weighted_average($request['id']),
            'breakdown' => $scoring->get_section_breakdown($request['id'])
        ];
    }

    public function check_admin_permissions()
    {
        return current_user_can('manage_options');
    }
}