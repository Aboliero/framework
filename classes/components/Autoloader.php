<?php

namespace components;

use UserPanelWidget;

class Autoloader extends \Component
{
    public function getFileName($className)
    {
        if ($className == UserPanelWidget::class) {
           return PROJECT_ROOT . '/widgets/UserPanel/' . $className . '.php';
        }

        return PROJECT_ROOT . '/classes/' . join('/', explode('\\', $className)) . '.php'; //- смена пути на правильный
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