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
     * @var Autoloader
     */
    public $autoloader;
    /**
     * @var Session
     */
    public $session;
    /**
     * @var FlashMessage
     */
    public $flashMessages;
    /**
     * @var Database
     */
    public $db;

    /**
     * @param null $controllerName
     * @return Controller
     * @throws Exception
     */
    public function getController($controllerName = null)
    {
        if (is_null($controllerName)) {
            $controllerName = $this->defaultControllerName;
        }
        $className = ucfirst($controllerName) . 'Controller';
        if (!$this->autoloader->doesExist($className)) {
            throw new Exception('Нет такого контроллера');
        }

        $controller = new $className();
        $controller->app = $this;
        return $controller;
    }
}
