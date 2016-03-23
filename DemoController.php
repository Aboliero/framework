<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.03.2016
 * Time: 0:49
 */
class DemoController
{
    public $defaultActionName = 'hello';
    public function sortAction()
    {
        $numbers = explode(' ', $_POST['numbers']);
        sort($numbers);
        include 'views/demo/sort.php';
    }

    public function helloAction()
    {
        echo 'Hello, World!';
    }

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
}