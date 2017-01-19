<?php

namespace controllers;
use Controller;
use Exception;
use City;
use Country;
use DateTime;

class CityController extends Controller
{
    public $defaultActionName = 'list';

    public function listAction()
    {
        $cities = City::getObjects();
        $this->render('list', ['cities' => $cities]);
    }

    public function viewAction()
    {
        if (!isset($_GET['id']) || !$_GET['id']) {
            throw new Exception('Не выбран город');
        }
        
        $city = City::getById($_GET['id']);
        if (is_null($city)) {
            throw new Exception('Не существует такого id города');
        }
        
        $this->render('view', ['city' => $city]);
    }

    public function editAction()
    { 
        if (!isset($_GET['id']) || !$_GET['id']) {
            throw new Exception('Не выбран город');
        }

        $city = City::getById($_GET['id']);

        if (isset($_POST['submit'])) {
            $city->name = $_POST['name'];
            $city->population = $_POST['population'];
            $city->countryId = $_POST['countryId'] == '' ? null : $_POST['countryId'];
            $city->unemploymentRate = $_POST['unemploymentRate'] / 100;
            $city->creationDateObject = $_POST['creationDateObject'] == '' ? null : DateTime::createFromFormat('d.m.Y', $_POST['creationDateObject']);
            $isSaved = $city->save();
            
            if ($isSaved) {
                $this->app->flashMessages->add('
                    <strong>Сохранено</strong> <br>
                ');
            } else {
                $this->app->flashMessages->add('
                    <strong> Не сохранено: ' . join('<br>', $city->errorMessages) . '</strong> <br>
                ');
            }
        }


        if (is_null($city)) {
            throw new Exception('Не существует такого id города');
        }


        $this->render('edit', ['city' => $city]);
    }

       
    public function addAction()
    {
        $city = new City();

        if (isset($_POST['submit'])) {


            $city->name = $_POST['name'];
            $city->population = $_POST['population'];
            $city->countryId = $_POST['countryId'] == 'unselected' ? null : $_POST['countryId'];
            $city->creationDateObject = $_POST['creationDateObject'] == '' ? null : DateTime::createFromFormat('d.m.Y', $_POST['creationDateObject']);;
            $city->unemploymentRate = $_POST['unemploymentRate'] / 100;
            $isSaved = $city->save();


            if ($isSaved) {
                $this->app->flashMessages->add('
                    <strong>ВНЕМАНИЕ!!! ГОРАД ДАБАВЛИН!!!</strong> <br>
                    <a href="/city/edit?id=' . $city->id . '">Редактировать новый город</a>
                ');

                header('Location: /city/list');

                exit;
            } else {
                $this->app->flashMessages->add('
                    <strong>Ошибка. Чот не так. Город не сохранён.</strong> <br>
                ');
            }
        }

        $countries = Country::getObjects();
        $this->render('edit', ['city' => $city, 'isSaved' => false, 'countries' => $countries]);
    }


    public function deleteAction()
    {
        $id = $_GET['id'];
        $city = City::getById($id);
        if (!$city) {
            throw new Exception('ААА!!! ЖОСТЬ! ГОРАДА НЕТ!! ПИЗДА!');
        }

        if (isset($_POST['confirm'])) {
            $city->delete();
            $this->app->flashMessages->add('ВНЕМАНИЕ!!! ГОРАД ' . $city->name . ' УДАЛЁН!!!</strong>');
            
            header('Location: /city/list');

            exit;
        }

        if (isset($_POST['cancel'])) {
            header('Location: /city/list');

            exit;
        }

        $this->render('delete', ['city' => $city]);
    }
    
}