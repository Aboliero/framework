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
 * @property Country||null $country
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
     * @return Country[]
     */
    public function getCountries()
    {
        return Country::getObjects();
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

    public function getFieldLabels()
    {
        return [
            'name' => 'Название',
            'population' => 'Население',
            'unemploymentRate' => 'Уровень безработицы',
            'countryId' => 'Страна',
            'creationDateObject' => 'Дата создания'
        ];
    }

    public function getValidationRules()
    {
        return [
            ['field' => 'name', 'validator' => \validators\EmptinessValidator::class, 'params' => ['not' => true]],
        ];
    }
}