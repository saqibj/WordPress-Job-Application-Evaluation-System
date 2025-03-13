<?php
namespace CJM\Database;

defined('ABSPATH') || exit;

class Evaluations
{
    private $table;
    private $db;

    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->table = $wpdb->prefix . 'cjm_evaluations';
    }

    /**
     * Insert evaluation data
     */
    public function insert_evaluation(int $application_id, int $interviewer_id, array $data)
    {
        return $this->db->insert(
            $this->table,
            [
                'application_id' => $application_id,
                'interviewer_id' => $interviewer_id,
                'section' => $data['section'],
                'criterion' => $data['criterion'],
                'rating' => $data['rating'],
                'comments' => sanitize_textarea_field($data['comments'])
            ],
            ['%d', '%d', '%s', '%s', '%d', '%s']
        );
    }

    /**
     * Get evaluations for an application
     */
    public function get_evaluations(int $application_id)
    {
        return $this->db->get_results(
            $this->db->prepare(
                "SELECT * FROM {$this->table}
                WHERE application_id = %d
                ORDER BY evaluated_at DESC",
                $application_id
            )
        );
    }

    /**
     * Get average rating for an application
     */
    public function get_average_rating(int $application_id)
    {
        return $this->db->get_var(
            $this->db->prepare(
                "SELECT AVG(rating) FROM {$this->table}
                WHERE application_id = %d AND rating > 0",
                $application_id
            )
        );
    }

    /**
     * Delete evaluations by application ID
     */
    public function delete_by_application(int $application_id)
    {
        return $this->db->delete(
            $this->table,
            ['application_id' => $application_id],
            ['%d']
        );
    }
}