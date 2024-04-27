<?php
namespace App;

class Session
{
    public static function start()
    {
        session_start();
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function generateCsrfToken($key = 'csrf_token')
    {
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = bin2hex(random_bytes(32)); // Generate a random token
        }
        return $_SESSION[$key];
    }

    public static function verifyCsrfToken($token, $key = 'csrf_token')
    {
        return isset($_SESSION[$key]) && hash_equals($_SESSION[$key], $token);
    }
}
