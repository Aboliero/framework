<?php

namespace controllers;
use Exception;
use Country;
use Controller;

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
        if (!isset($_GET['id']) || !$_GET['id']) {
            throw new Exception('Не выбрана страна');
        }

        $country = Country::getById($_GET['id']);

        $this->render('view', ['country' => $country]);
    }

    public function editAction()
    {
        if (!isset($_GET['id']) || !$_GET['id']) {
            throw new Exception('Не выбрана страна');
        }
        
        $isSaved = false;
        
        $country = Country::getById($_GET['id']);
        
        if (isset($_POST['submit'])) {
            $country->name = $_POST['name'];
            $country->area = $_POST['area'];
            $country->capitalId = $_POST['capitalId'] == '' ? null : $_POST['capitalId'];
            $country->citysum = $_POST['citysum'];
            $country->save();

            $isSaved = true;
        }

        if (is_null($country)) {
            throw new Exception('Не существует такой страны');
        }

        $cities = $country->getCities();

        $this->render('edit', ['cities' => $cities, 'isSaved' => $isSaved, 'country' => $country]);
    }

    public function addAction()
    {
        $country = new Country();

        if (isset($_POST['submit'])) {
            $country->name = $_POST['name'];
            $country->area = $_POST['area'];
            $country->capitalId = $_POST['capitalId'] == '' ? null : $_POST['capitalId'];
            $country->citysum = $_POST['citysum'];
            $country->save();

            $this->app->flashMessages->add('
                <strong>ВНЕМАНИЕ!!! СТРАНА ДАБАВЛИНА!!!</strong> <br>
                <a href="/country/edit?id=' . $country->id . '">Редактировать новый город</a>
            ');

            header('Location: /country/list');

            exit;
        }

        $this->render('edit', ['isSaved' => false, 'country' => $country]);
    }

    public function deleteAction()
    {
        $country = Country::getById($_GET['id']);
        
        if (!$country) {
            throw new Exception('ААА!!! ЖОСТЬ! СТРАНЫ НЕТ!! ПИЗДА!');
        }

        if (isset($_POST['confirm'])) {
            if ($country->getCities()) {
                $this->app->flashMessages->add('ВНЕМАНИЕ!!! Чтобы удалить страну - ей не должен принадлежать ни один город!');

                header('Location: /country/list');

                exit;
            }
            
            $country->delete();
            $this->app->flashMessages->add('ВНЕМАНИЕ!!! СТРАНА ' . $country->name . ' УДАЛЕНА!!!</strong>');

            header('Location: /country/list');

            exit;
        }

        if (isset($_POST['cancel'])) {
            header('Location: /country/list');

            exit;
        }

        $this->render('delete', ['country' => $country]);
    }

}