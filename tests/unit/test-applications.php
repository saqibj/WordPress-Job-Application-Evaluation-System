<?php
namespace CJM\Tests;

use CJM\Database\Applications;

class ApplicationsTest extends \WP_UnitTestCase
{
    public function test_application_creation()
    {
        $db = new Applications();
        $app_id = $db->insert_application([
            'job_id' => 1,
            'candidate_name' => 'Test Candidate',
            'candidate_email' => 'test@example.com',
            'resume_path' => '/uploads/test.pdf'
        ]);

        $this->assertIsInt($app_id);
        $this->assertGreaterThan(0, $app_id);
    }
}