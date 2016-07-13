<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.04.2016
 * Time: 22:13
 */
class Database
{
    /**
     * @var mysqli
     */
    public $connection;

    public function connect($serverName, $userName, $userPassword, $dbName)
    {
        $this->connection = new mysqli($serverName, $userName, $userPassword, $dbName);
        if ($this->connection->connect_error) {
            throw new Exception('Ошибка подключения (' . $this->connection->connect_errno . ') '
                . $this->connection->connect_error);
        }
        if (!$this->connection->set_charset('utf8')) {
            throw new Exception('Ошибка при загрузке набора символов utf8 (' . $this->connection->error);
        }
    }

    public function sendQuery($query)
    {
        $result = $this->connection->query($query);
        if (!$result) {
            throw new Exception('Ошибка подключения (' . $this->connection->errno . ') '
                . $this->connection->error);
        }

        if ($result === true) {
            return true;
        } else {
            $results = [];
            while ($row = $result->fetch_assoc()) {
                $results[] = $row;
            }
            $result->free();
            
            return $results;
        }

    }

    /**
     * @param $name string неэкранированное имя
     * @return string экранированное имя
     */
    public static function escapePartialName($name) // экранирование частей имени
    {
        if ($name !== '*') {
            $name = str_replace('`', '``', $name);
            $name = '`' . $name . '`';
        }

        return $name;
    }

    /**
     * @param $name string неэкранированное имя
     * @return string экранированное имя
     */    
    public static function escapeName($name)
    {
        $names = explode('.', $name);
        $names = array_map ([static::class, 'escapePartialName'], $names); // синтаксис collable
        $names = join('.', $names);
        
        return $names;
    }

    /**
     * @param $name DatabaseExpression|string
     * @return string
     */
    public static function escapeAnyName($name)
    {
        return $name instanceof DatabaseExpression
            ? $name->getEscapedValue()
            : static::escapeName($name);                
    }
}