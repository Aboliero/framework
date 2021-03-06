<?php

namespace components;

class Request extends \Component
{
    public function getParam($paramName)
    {
       return isset($_REQUEST[$paramName]) ? $_REQUEST[$paramName] : null;
    }

    public function __get($propertyName)
    {
        return $this->getParam($propertyName);
    }
}