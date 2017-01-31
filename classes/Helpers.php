<?php

class Helpers
{
    /**
     * @param ActiveRecord[] $models
     * @param string $keyName
     * @param string $valueName
     * @return array
     */
    public static function getMap($models, $keyName, $valueName)
    {
        $map = [];
        foreach ($models as $model) {
            $key = $model->$keyName;
            $value = $model->$valueName;
            $map[$key] = $value;
        }

        return $map;
    }
}