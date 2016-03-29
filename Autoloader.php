<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.03.2016
 * Time: 0:30
 */
class Autoloader
{
    public function getFileName($className)
    {
        return $className . '.php';
    }

    public function load($className)
    {
        require_once $this->getFileName($className);
    }

    public function register()
    {
        spl_autoload_register([$this, 'load']);
    }

    public function doesExist($className)
    {
        return file_exists($this->getFileName($className));
    }
}