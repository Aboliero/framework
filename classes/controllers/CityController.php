<?php

namespace controllers;
use Controller;
use DatabaseFieldExpression;
use Exception;
use Query;
use City;

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

        $isSaved = false;
        if (isset($_POST['submit'])) {
            $city = new City(false);
            $city->name = $this->app->db->connection->real_escape_string($_POST['name']);
            $city->population = $this->app->db->connection->real_escape_string($_POST['population']);
            $city->id = $this->app->db->connection->real_escape_string($_GET['id']);
            $city->countryId = $this->app->db->connection->real_escape_string($_POST['countryId']);
            $city->unemploymentRate = $this->app->db->connection->real_escape_string($_POST['unemploymentRate'] / 100);
            //$this->app->db->sendQuery("UPDATE cities SET name = '$name', population = '$population', countryId = '$countryId', unemploymentRate = '$unemploymentRate' WHERE id = '$id'");
            $city->save();

            $isSaved = true;
        }


        $city = City::getById($_GET['id']);
        if (is_null($city)) {
            throw new Exception('Не существует такого id города');
        }

        $query = new Query($this->app->db);
        $query->select(['name', 'id'])->from('countries');
        $countries = $query->getRows();

        $this->render('edit', ['city' => $city, 'isSaved' => $isSaved, 'countries' => $countries]);
    }

    /**
     * @param $id int
     * @return string[]
     */
    public function getCity($id)
    {
        $query = new Query($this->app->db);
        $query
            ->select(['cities.*', 'countries.name countryName'])
            ->from('cities')
            ->leftJoin('countries', ['=', 'cities.countryId', new DatabaseFieldExpression('countries.id')])
            ->where(['=', 'cities.id', $id]);
        $city = $query->getRow();

        return $city;
    }

    public function addAction()
    {
        $city = new City();

        if (isset($_POST['submit'])) {

            $city->name = $this->app->db->connection->real_escape_string($_POST['name']);
            $city->population = $this->app->db->connection->real_escape_string($_POST['population']);
            $city->countryId = $this->app->db->connection->real_escape_string($_POST['countryId']);
            //$this->app->db->sendQuery("INSERT INTO `cities` SET name = '$name', population = '$population', countryId = '$countryId'");
            $city->save();

            $newId = $this->app->db->connection->insert_id;

            $this->app->flashMessages->add('
                <strong>ВНЕМАНИЕ!!! ГОРАД ДАБАВЛИН!!!</strong> <br>
                <a href="/city/edit?id=' . $newId . '">Редактировать новый город</a>
            ');

            header('Location: /city/list');

            exit;
        }

        $query = new Query($this->app->db);
        $query->select(['name', 'id'])->from('countries');
        $countries = $query->getRows();

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