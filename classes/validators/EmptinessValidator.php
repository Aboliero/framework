<?php

namespace validators;

class EmptinessValidator
{
    public static function isValid($value, $params = [], \ActiveRecord $model)
    {
        
        if (isset($params['not']) && $params['not']) {
            $result = !empty($value);
            if (!$result) {
                $model->addErrorMessage('Значение пустое');
            }
            
        } else {
            $result = empty($value);
            if (!$result) {
                $model->addErrorMessage('Значение не пустое');
            }
        }
        
        return $result;
    }
}