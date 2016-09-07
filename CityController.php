<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.07.2016
 * Time: 22:58
 */
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
}