<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.09.2016
 * Time: 23:51
 */
class Session
{
    function __construct()
    {
        session_start();
    }

    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function __get($name)
    {
        return $_SESSION[$name];
    }

    public function __isset($name)
    {
        return isset($_SESSION[$name]);
    }
}