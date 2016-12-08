<?php
/**
 * class Country
 * @property $id int
 * @property $name string
 * @property $area string
 * @property $citysum string
 * @property $capitalId int
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
}