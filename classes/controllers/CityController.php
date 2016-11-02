<?php

namespace controllers;
use Controller;
use DatabaseFieldExpression;
use Exception;
use Query;

class CityController extends Controller
{
    public $defaultActionName = 'list';
    public function listAction()
    {
        $query = new Query($this->app->db);
        $query->select()->from('cities');
        $cities = $query->getRows();

        $this->render('list', ['cities' => $cities]);
    }

    public function viewAction()
    {
        if (!isset($_GET['id']) || !$_GET['id']) {
            throw new Exception('Не выбран город');
        }
        
        $city = $this->getCity($_GET['id']);
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
            $name = $this->app->db->connection->real_escape_string($_POST['name']);
            $population = $this->app->db->connection->real_escape_string($_POST['population']);
            $id = $this->app->db->connection->real_escape_string($_GET['id']);
            $countryId = $this->app->db->connection->real_escape_string($_POST['countryId']);
            $this->app->db->sendQuery("UPDATE cities SET name = '$name', population = '$population', countryId = '$countryId' WHERE id = '$id'");

            $isSaved = true;
        }


        $city = $this->getCity($_GET['id']);
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

        if (isset($_POST['submit'])) {
            $name = $this->app->db->connection->real_escape_string($_POST['name']);
            $population = $this->app->db->connection->real_escape_string($_POST['population']);
            $countryId = $this->app->db->connection->real_escape_string($_POST['countryId']);
            $this->app->db->sendQuery("INSERT INTO `cities` SET name = '$name', population = '$population', countryId = '$countryId'");

            $newId = $this->app->db->connection->insert_id;

            $this->app->flashMessages->add('
                <strong>ВНЕМАНИЕ!!! ГОРАД ДАБАВЛИН!!!</strong> <br>
                <a href="/city/edit?id=' . $newId . '">Редактировать новый город</a>
            ');

            header('Location: /city/list');

            exit;
        }

        $city = [
            'id' => null,
            'name' => '',
            'population' => null,
            'isCapital' => null,
            'creationDate' => null,
            'unemploymentRate' => null,
            'countryId' => '',
        ];

        $query = new Query($this->app->db);
        $query->select(['name', 'id'])->from('countries');
        $countries = $query->getRows();

        $this->render('edit', ['city' => $city, 'isSaved' => false, 'countries' => $countries]);
    }


    public function deleteAction()
    {
        $id = $_GET['id'];
        $city = $this->getCity($id);
        if (!$city) {
            throw new Exception('ААА!!! ЖОСТЬ! ГОРАДА НЕТ!! ПИЗДА!');
        }

        if (isset($_POST['confirm'])) {
            $delId = $this->app->db->connection->real_escape_string($id);
            $this->app->db->sendQuery("DELETE FROM `cities` WHERE `id` = '$delId' ");

            $this->app->flashMessages->add('ВНЕМАНИЕ!!! ГОРАД ' . $city['name'] . ' УДАЛЁН!!!</strong>');
            
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