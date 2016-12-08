<?php
/**
 * Class City
 * @property $name string
 * @property $population int
 * @property $isCapital int
 * @property $id int
 * @property $creationDate string
 * @property $unemploymentRate float
 * @property $countryId int
 */
class City extends ActiveRecord
{
    public static function getTableName()
    {
        return 'cities';
    }

    /**
     *  @return Country
     */
    public function getCountry()
    {
        return Country::getById($this->countryId);
    }
}