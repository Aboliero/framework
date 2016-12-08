<?php

namespace controllers;
use Exception;
use Country;

class CountryController extends \Controller
{
    public $defaultActionName = 'list';
    public function listAction()
    {
        $countries = Country::getObjects();

        $this->render('list', ['countries' => $countries]);
    }

    public function viewAction()
    {
        $country = Country::getById($_GET['id']);
        if (!isset($_GET['id']) || !$_GET['id']) {
            throw new Exception('Не выбрана страна');
        }

        $this->render('view', ['country' => $country]);
    }

}