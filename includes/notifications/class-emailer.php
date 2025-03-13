<?php
namespace CJM\Notifications;

defined('ABSPATH') || exit;

class Emailer
{
    public static function send(string $to, string $subject, string $template, array $data = [])
    {
        $headers = ['Content-Type: text/html; charset=UTF-8'];
        $message = self::render_template($template, $data);
        
        return wp_mail($to, $subject, $message, $headers);
    }

    private static function render_template(string $template, array $data)
    {
        ob_start();
        extract($data);
        include CJM_TEMPLATE_PATH . "emails/{$template}";
        return ob_get_clean();
    }
}