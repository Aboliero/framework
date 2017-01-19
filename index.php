<?php

//include - для активных
//require_once -  для объявлений
use components\Autoloader;


ini_set('display_errors', '1');
header('Content-Type: text/html; charset=utf-8');

define('PROJECT_ROOT', __DIR__);

require_once 'classes/Component.php'; // запросить_однажды 'классы/Компонента.пхп' 

require_once 'classes/components/Autoloader.php'; // запросить_однажды 'классы/компоненты/Автозагрузчик.пхп' 

$autoloader = new Autoloader(); // $автозагрузчик = новый Автозагрузчик
$autoloader->register();

$config = include 'config.php';

$application = Application::getInstance();
$application->autoloader = $autoloader;
$application->configure($config);

//$country = Country::getObjects();
//var_dump($country);
//
//exit;

$route = $application->urlManager->getCurrentRoute();

$controller = $application->getController($route->controllerName);
$controller->execute($route->actionName);
