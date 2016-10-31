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

require_once 'classes/components/Autoloader.php';
$autoloader = new Autoloader();
$autoloader->register();
$database = new Database();
$database->connect('buncha.ru', 'root', 'pi31415', 'Aboliero');

$session = new Session();
$request = new Request();
$flashMessages = new FlashMessage($session);

$urlManager = new UrlManager();
$route = $urlManager->getCurrentRout();

$user = new User($session, $database);

$application = Application::getInstance();
$application->session = $session;
$application->request = $request;
$application->autoloader = $autoloader;
$application->db = $database;
$application->flashMessages = $flashMessages;
$application->user = $user;


$controller = $application->getController($route->controllerName);
$controller->execute($route->actionName);