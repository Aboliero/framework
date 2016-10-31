<?php

namespace components;

use Exception;
use Route;

class UrlManager
{
    /**
     * @return Route
     * @throws exception
     */
    public function getCurrentRout()
    {
        $path = $_SERVER['REQUEST_URI'];
        if (substr($path, 0, 1) == '/') {
            $path = substr($path, 1);
        }
        $queryPos = strpos($path, '?');
        if ($queryPos !== false) {
            $path = substr($path, 0, $queryPos);
        }
        $path = explode('/', $path);
        if (count($path) > 2) {
            throw new Exception('Слишком много элементов в пути');
        }
        $route = new Route();
        $route->hostName = $_SERVER['HTTP_HOST'];
        if ($path[0] != '') {
            $route->controllerName = $path[0];
        }
        if (isset($path[1]) && $path[1] != '') {
            $route->actionName = $path[1];
        }
        $route->params = $_GET;

        return $route;
    }

}