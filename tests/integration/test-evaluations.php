<?php
namespace CJM\Tests;

use CJM\Database\Evaluations;

class EvaluationsTest extends \WP_UnitTestCase
{
    public function test_evaluation_scoring()
    {
        $db = new Evaluations();
        $db->insert_evaluation(1, 1, [
            'section' => 'core',
            'criterion' => 'analytical_skills',
            'rating' => 4,
            'comments' => 'Good skills'
        ]);

        $avg = $db->get_average_rating(1);
        $this->assertEquals(4.0, $avg);
    }
}