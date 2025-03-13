<?php
namespace CJM\Security;

defined('ABSPATH') || exit;

class Sanitization
{
    public static function text(string $input): string
    {
        return \sanitize_text_field(\wp_unslash($input));
    }

    public static function email(string $input): string
    {
        return \sanitize_email(\wp_unslash($input));
    }

    public static function html(string $input): string
    {
        return \wp_kses_post(\wp_unslash($input));
    }

    public static function filename(string $filename): string
    {
        return \sanitize_file_name($filename);
    }

    public static function array(array $data, callable $callback): array
    {
        return array_map($callback, $data);
    }
}