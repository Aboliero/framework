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
        $errors = [];
        $numbers = str_replace(["\n", "\r"], ' ', $_POST['numbers']);
        $numbers = explode(' ', $numbers);
        $numbers = array_filter($numbers, function ($number) {
            return $number != '';
        });
        if (!$numbers) {
            $errors[] = 'Пустое поле!';
        }
        foreach ($numbers as $number) {
            if (!is_numeric($number)) {
                $errors[] = '"' . $number . '" не число!';
            };
        }
        if (!$errors) {
            sort($numbers);
        }
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