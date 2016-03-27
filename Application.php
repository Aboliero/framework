<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.03.2016
 * Time: 1:33
 */
class Application
{
    public $defaultControllerName = 'demo';
    /**
     * @var Request
     */
    public $request;

    /**
     * @param null $controllerName
     * @return DemoController
     * @throws Exception
     */
    public function getController($controllerName = null)
    {
        if (is_null($controllerName)) {
            $controllerName = $this->defaultControllerName;
        }
        $className = ucfirst($controllerName) . 'Controller';
        $fileName = $className . '.php';
        if (!file_exists($fileName)) {
            throw new Exception('Нет такого контроллера');
        }
        require_once $fileName;

        $controller = new $className();
        $controller->app = $this;
        return $controller;
    }
}
