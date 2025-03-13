<?php
namespace CJM\Security;

defined('ABSPATH') || exit;

class Nonces
{
    public static function create(string $action): string
    {
        return wp_create_nonce("cjm_{$action}_nonce");
    }

    public static function verify(string $nonce, string $action): bool
    {
        return (bool) wp_verify_nonce($nonce, "cjm_{$action}_nonce");
    }

    public static function field(string $action): void
    {
        wp_nonce_field("cjm_{$action}_nonce", "cjm_{$action}_nonce");
    }
}