<?php
namespace CJM\Tests;

use CJM\Security\Sanitization;

class SecurityTest extends \WP_UnitTestCase
{
    public function test_sanitization_functions()
    {
        $dirty = '<script>alert()</script>Test';
        $clean = Sanitization::text($dirty);
        $this->assertEquals('Test', $clean);
    }

    public function test_email_validation()
    {
        $this->assertTrue(Validation::is_valid_email('test@valid.com'));
        $this->assertFalse(Validation::is_valid_email('invalid-email'));
    }
}