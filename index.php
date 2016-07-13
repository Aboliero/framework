<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.03.2016
 * Time: 20:29
 * точка входа
 */
//include - для активных
//require_once -  для объявлений
ini_set('display_errors', '1');
header('Content-Type: text/html; charset=utf-8');

require_once 'Autoloader.php';
$autoloader = new Autoloader();
$autoloader->register();
$database = new Database();
$database->connect('buncha.ru', 'root', 'pi31415', 'Aboliero');
//$queryData = $database->sendQuery('SELECT * FROM cities');
$query = new Query($database);
//print_r($queryData);
print_r($query
    ->select(['cities.name as cities', 'countries.name as country'])
    ->from('cities')
    ->join('countries', ['=', 'countries.id', new DatabaseFieldExpression('cities.countryId')])
    ->group(['country', 'isCapital'])
    ->order(['country'])
    ->getRows()
);
exit;

$request = new Request();


$urlManager = new UrlManager();
$route = $urlManager->getCurrentRout();



$application = new Application();
$application->request = $request;
$application->autoloader = $autoloader;

$controller = $application->getController($route->controllerName);
$controller->execute($route->actionName);