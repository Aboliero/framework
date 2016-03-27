<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2016
 * Time: 22:11
 */
abstract class Controller // запрещает создание экземпляра этого класса
{

    public $defaultActionName = 'default';
    /**
     * @var Application
     */
    public $app;
    public function execute($actionName = null)
    {
        if (is_null($actionName)) {
            $actionName = $this->defaultActionName;
        }
        $methodName = $actionName . 'Action';
        if (!method_exists($this, $methodName)) {
            throw new exception('Нет такого действия!');
        };
        $this->$methodName();
    }

    public function getName()
    {
        $className = get_class($this);
        $controllerName = substr($className, 0, strrpos($className, 'Controller'));

        return $controllerName;
    }

    public function render($viewName, $data = [])
    {
        $__fileName = 'views/' . $this->getName() . '/' . $viewName . '.php';
        if (!file_exists($__fileName)) {
            throw new Exception('Нет такого представления!');
        }
        extract($data);

        include $__fileName;
    }
}