<?php
/**
 * class Country
 * @property $id int
 * @property $name string
 * @property $area string
 * @property $citysum string
 * @property $capitalId int
 * @property-read City|null $capital
 * @property-read City[] $cities
 */
class Country extends ActiveRecord
{
    public static function getTableName()
    {
        return 'countries';
    }

    /**
     * @return City|null
     */
    public function getCapital()
    {
        return City::getById($this->capitalId);
    }

    /**
     * @return City[]
     */
    public function getCities()
    {
        return City::getObjects(['=', 'countryId', $this->id]);
    }
}