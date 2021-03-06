<?php

namespace components;

use DatabaseExpression;
use Exception;
use mysqli;

class Database extends \Component
{
    /**
     * @var mysqli
     */
    public $connection;

    public function __construct($params)
    {
        $this->connect($params['hostname'], $params['username'], $params['password'], $params['dbName']);
    }

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

    public function formatSetQueryPart($fields)
    {
        $keys = array_keys($fields);
        $values = array_values($fields);
        $params = join(', ', array_map(function($key, $value) {
            if (is_null($value)) {
                $sqlValue = 'NULL';
            } else {
                $sqlValue = "'" . $this->connection->real_escape_string($value) . "'";
            }

            return $this->escapeName($key) . ' = ' . $sqlValue;
        }, $keys, $values));
        
        return $params;
    }
}