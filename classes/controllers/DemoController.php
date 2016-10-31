<?php

namespace controllers;

use City;
use Controller;

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
                }
            }
            if (!$errors) {
                sort($numbers);
            }
        }
        $this->render('sort', ['numbers' => $numbers, 'errors' => $errors]);
    }

    public function helloAction()
    {
        $this->render('hello');
    }

    public function testAction()
    {
        $city1 = City::getById(1);
        $city1->name = 'Moscow';
        $city1->save();
    }
}