<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.05.2016
 * Time: 23:11
 */
class DatabaseFieldExpression extends DatabaseExpression
{
    public function getEscapedValue()
    {
        return Database::escapeName($this->value);
    }
}