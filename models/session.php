<?php

class Session
{
    public static $key = "admin";
    
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function initialize($key)
    {
        self::start();
        $_SESSION[$key] = [];
    }

    public static function clear()
    {
        self::start();
        unset($_SESSION[self::$key]);
        session_unset();
        session_destroy();
    }

    public static function isset()
    {
        self::start();
        return isset($_SESSION[self::$key]);
    }

    public static function get($key)
    {
        self::start();
        if(!self::isset()) return "";
        return $_SESSION[self::$key][$key] ?? "";
    }

    public static function set($key, $value)
    {
        self::start();
        if(self::isset()) {
            $_SESSION[self::$key][$key] = $value;

            return true;
        } 
        return false;
    }
}
