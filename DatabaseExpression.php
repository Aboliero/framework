<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.05.2016
 * Time: 22:55
 */
class DatabaseExpression
{
    /**
     * @var string
     */
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getEscapedValue()
    {
        return $this->value;
    }
}