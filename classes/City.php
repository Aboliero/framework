<?php
/**
 * Class City
 * @property $name string
 * @property $population string
 * @property $isCapital string
 * @property $id string
 */
class City extends ActiveRecord
{
    public static function getTableName()
    {
        return 'cities';
    }

}