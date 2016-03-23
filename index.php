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
require_once 'UrlManager.php';
$urlManager = new UrlManager();
$route = $urlManager->getCurrentRout();


require_once 'Application.php';
$application = new Application();

$controller = $application->getController($route->controllerName);
$controller->execute($route->actionName);