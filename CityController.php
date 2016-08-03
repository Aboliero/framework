<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.07.2016
 * Time: 22:58
 */
class CityController extends Controller
{
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

        $id = $_GET['id'];

        $query = new Query($this->app->db);
        $query->select()->from('cities')->where(['=', 'id', $id]);
        $city = $query->getRow();
        if (is_null($city)) {
            throw new Exception('Не существует такого id города');
        }
        
        $this->render('view', ['city' => $city]);
    }
}