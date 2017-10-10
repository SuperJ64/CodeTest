<?php

/**
 * Class Session is a wrapper for accessing session data
 */
class Session
{
    public static function exists($key) {
        if (isset($_SESSION[$key])) {
            return true;
        }

        return false;
    }

    public static function put($key, $value) {
        return $_SESSION[$key] = $value;
    }

    public static function get($key) {
        return $_SESSION[$key];
    }

    public static function delete($key) {
        if (self::exists($key)) {
            unset($_SESSION[$key]);
        }
    }

    public static function flash() {
        session_destroy();
    }

}