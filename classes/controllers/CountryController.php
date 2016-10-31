<?php

namespace controllers;
use DatabaseFieldExpression;
use Exception;
use Query;

class CountryController extends \Controller
{
    public $defaultActionName = 'list';
    public function listAction()
    {
        $query = new Query($this->app->db);
        $query->select()->from('countries');
        $countries = $query->getRows();

        $this->render('list', ['countries' => $countries]);
    }

    public function viewAction()
    {
        $country = $this->getCountry($_GET['id']);
        if (!isset($_GET['id']) || !$_GET['id']) {
            throw new Exception('Не выбрана страна');
        }

        $city = $this->getCountry($_GET['id']);
        if (is_null($city)) {
            throw new Exception('Не существует такого id страны');
        }

        $this->render('view', ['country' => $country]);
    }
    
    public function getCountry($id)
    {
        $query = new Query($this->app->db);
        $query
            ->select(['countries.*', 'cities.name capitalName'])
            ->from('countries')
            ->leftJoin('cities', ['=', 'countries.capitalId', new DatabaseFieldExpression('cities.id')])
            ->where(['=', 'countries.id', $id]);
        $country = $query->getRow();

        return $country;
    }

}