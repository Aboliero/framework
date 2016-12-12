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
 * @property DateTime|null $creationDateObject
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
    
    /**
     * @return DateTime|null
     */
    public function getCreationDateObject()
    {
        return is_null($this->creationDate) ? null : DateTime::createFromFormat('Y-m-d', $this->creationDate);
    }

    /**
     * @param DateTime|null $value
     * @return null|string
     */
    public function setCreationDateObject($value)
    {
        $this->creationDate = $value ? $value->format('Y-m-d') : null;
    }
    
    public function __get($name)
    {
        if ($name == 'creationDateObject') {
            return $this->getCreationDateObject();
        }
        
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if ($name == 'creationDateObject') {
            $this->setCreationDateObject($value);

            return;
        }
        
        parent::__set($name, $value);
    }
}