<?php

namespace validators;

class EmptinessValidator
{
    public static function isValid($value, $params = [])
    {
        if (isset($params['not']) && $params['not']) {
            return !empty($value);
        }
        
        return empty($value);
    }
}