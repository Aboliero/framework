<?php

/**
 * Class User
 * @property $username string
 * @property $password string
 * @property $id    string
 */
class User extends ActiveRecord
{
    public static function getTableName()
    {
        return 'authentic';
    }
}