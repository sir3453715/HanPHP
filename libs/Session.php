<?php
class Session
{
    
    public static function init()
    {
        @session_start();
    }
    
    public static function set($key, $value,$target='client')
    {
        $_SESSION[$target][$key] = $value;
    }
    
    public static function get($key,$target='client')
    {
        if (isset($_SESSION[$target][$key]))
        return $_SESSION[$target][$key];
    }
    
    public static function destory($target='client')
    {
        unset($_SESSION[$target]);
        $_SESSION[$target] = null;
        //@session_destroy();
    }
    
}