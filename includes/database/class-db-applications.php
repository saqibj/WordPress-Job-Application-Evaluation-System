<?php
namespace CJM\Database;

defined('ABSPATH') || exit;

class Applications
{
    private $table;
    private $db;

    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->table = $wpdb->prefix . 'cjm_applications';
    }

    /**
     * Create new application
     * @param array $data {
     *     @type int    $job_id
     *     @type string $candidate_name
     *     @type string $candidate_email
     *     @type string $resume_path
     * }
     * @return int|false Insert ID or false on failure
     */
    public function insert_application(array $data)
    {
        $defaults = [
            'status' => 'new',
            'created_at' => current_time('mysql'),
        ];

        $data = wp_parse_args($data, $defaults);
        
        $result = $this->db->insert(
            $this->table,
            [
                'job_id' => $data['job_id'],
                'candidate_name' => sanitize_text_field($data['candidate_name']),
                'candidate_email' => sanitize_email($data['candidate_email']),
                'resume_path' => esc_url_raw($data['resume_path']),
                'status' => $data['status'],
                'created_at' => $data['created_at']
            ],
            ['%d', '%s', '%s', '%s', '%s', '%s']
        );

        return $result ? $this->db->insert_id : false;
    }

    /**
     * Get application by ID
     * @param int $application_id
     * @return object|null
     */
    public function get_application(int $application_id)
    {
        $query = $this->db->prepare(
            "SELECT * FROM {$this->table} 
            WHERE application_id = %d",
            $application_id
        );
        
        return $this->db->get_row($query);
    }

    /**
     * Get filtered applications
     * @param array $args {
     *     @type int    $job_id
     *     @type string $status
     *     @type int    $per_page
     *     @type int    $page
     * }
     * @return array
     */
    public function get_applications(array $args = [])
    {
        $defaults = [
            'job_id' => 0,
            'status' => '',
            'per_page' => 20,
            'page' => 1,
        ];
        $args = wp_parse_args($args, $defaults);

        $where = [];
        $params = [];

        if ($args['job_id'] > 0) {
            $where[] = 'job_id = %d';
            $params[] = $args['job_id'];
        }

        if (in_array($args['status'], ['new', 'in_review', 'archived'])) {
            $where[] = 'status = %s';
            $params[] = $args['status'];
        }

        $where = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $offset = ($args['page'] - 1) * $args['per_page'];

        $query = $this->db->prepare(
            "SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->table}
            {$where}
            ORDER BY created_at DESC
            LIMIT %d, %d",
            array_merge($params, [$offset, $args['per_page']])
        );

        $results = [
            'items' => $this->db->get_results($query),
            'total' => $this->db->get_var('SELECT FOUND_ROWS()'),
        ];

        return $results;
    }

    /**
     * Update application status
     * @param int    $application_id
     * @param string $new_status
     * @return bool
     */
    public function update_status(int $application_id, string $new_status)
    {
        if (!in_array($new_status, ['new', 'in_review', 'archived'])) {
            return false;
        }

        return (bool) $this->db->update(
            $this->table,
            ['status' => $new_status],
            ['application_id' => $application_id],
            ['%s'],
            ['%d']
        );
    }

    /**
     * Delete application and related evaluations
     * @param int $application_id
     * @return bool
     */
    public function delete_application(int $application_id)
    {
        $this->db->query('START TRANSACTION');

        try {
            // Delete evaluations first
            $evaluations = new Evaluations();
            $evaluations->delete_by_application($application_id);

            // Delete application
            $result = $this->db->delete(
                $this->table,
                ['application_id' => $application_id],
                ['%d']
            );

            $this->db->query('COMMIT');
            return (bool) $result;
        } catch (\Exception $e) {
            $this->db->query('ROLLBACK');
            error_log('Application deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    private function create_tables() {
        require_once(dirname(__FILE__) . '/schema.php');
        cjm_create_database_tables();
    }
}