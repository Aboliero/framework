<?php


use components\Autoloader;
use components\Database;
use components\FlashMessage;
use components\Request;
use components\Session;
use components\User;
use components\UrlManager;

class Application
{
    public $defaultControllerName = 'demo';

    /**
     * @var UrlManager
     */
    public $urlManager;
    
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
     * @var User
     */
    public $user;
    
    static private $instance;

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new static;
        }

        return static::$instance;
    }

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
        $className = 'controllers\\' . ucfirst($controllerName) . 'Controller';
        if (!$this->autoloader->doesExist($className)) {
            throw new Exception('Нет такого контроллера');
        }

        $controller = new $className();
        $controller->app = $this;
        return $controller;
    }
    
    public function configure($config)
    {
        $this->createComponents($config['components']);
    }

    public function createComponents($list)
    {
        foreach ($list as $name => $config) {
            $params = isset($config['params']) ? $config['params'] : [];
            $component = new $config['className']($params);
            $this->$name = $component;
        }
    }
}
