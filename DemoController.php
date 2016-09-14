<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.03.2016
 * Time: 0:49
 */

class DemoController extends Controller
{
    public $defaultActionName = 'hello'; // перегрузка св-ва controller::defaultactionname
    public function sortAction()
    {
        $numbers = [];
        $errors = [];
        $strNumbers = $this->app->request->numbers;
        if (isset($strNumbers)) {
            $numbers = str_replace(["\n", "\r"], ' ', $strNumbers);
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
        }
        $this->render('sort', ['numbers' => $numbers, 'errors' => $errors]);
    }

    public function helloAction()
    {
        echo 'Hello, World!';
        ?> <br> <br> <a href="/city/list">К списку городов</a> <?php
        ?> <br> <br> <a href="/country/list">К списку стран</a> <?php
    }
}