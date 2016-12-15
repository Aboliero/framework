<?php

namespace controllers;
use Exception;
use Country;
use Controller;
use City;
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
            throw new Exception('Не существует такого id города');
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

        $cities = $country->getCities();
        $this->render('edit', ['cities' => $cities, 'isSaved' => false, 'country' => $country]);
    }

    public function deleteAction()
    {
        $id = $_GET['id'];
        $country = Country::getById($id);
        $cities = $country->getCities();
        if (!$country) {
            throw new Exception('ААА!!! ЖОСТЬ! СТРАНЫ НЕТ!! ПИЗДА!');
        }


        if (isset($_POST['confirm'])) {
            if ($cities) {
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