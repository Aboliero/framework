<?php
/**
 * Class City
 * @property $name string
 * @property $population string
 * @property $isCapital string
 * @property $id string
 * @property $creationDate string
 * @property $unemploymentRate string
 * @property $countryId string
 */
class City extends ActiveRecord
{
    public static function getTableName()
    {
        return 'cities';
    }

}