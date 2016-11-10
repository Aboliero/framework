<?php

//include - для активных
//require_once -  для объявлений
use components\Autoloader;
use components\Database;
use components\FlashMessage;
use components\Request;
use components\Session;
use components\UrlManager;
use components\User;

ini_set('display_errors', '1');
header('Content-Type: text/html; charset=utf-8');

define('PROJECT_ROOT', __DIR__);

require_once 'classes/Component.php'; // запросить_однажды 'классы/Компонента.пхп' 

require_once 'classes/components/Autoloader.php'; // запросить_однажды 'классы/компоненты/Автозагрузчик.пхп' 

$autoloader = new Autoloader(); // $автозагрузчик = новый Автозагрузчик
$autoloader->register();
$database = new Database();
$database->connect('188.73.181.180', 'root', 'pi31415', 'Aboliero');

$session = new Session();
$request = new Request();
$flashMessages = new FlashMessage();

$urlManager = new UrlManager();
$route = $urlManager->getCurrentRoute();

$user = new User();

$application = Application::getInstance();
$application->session = $session;
$application->request = $request;
$application->autoloader = $autoloader;
$application->db = $database;
$application->flashMessages = $flashMessages;
$application->user = $user;


$controller = $application->getController($route->controllerName);
$controller->execute($route->actionName);