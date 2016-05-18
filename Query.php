<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.05.2016
 * Time: 21:59
 */
class Query
{

    /**
     * @var string[]
     */
    protected $select;
    /**
     * @var string[]
     */
    protected $from;
    /**
     * @var Database
     */
    protected $database;

    /**
     * @var array
     */
    protected $where;

    /**
     * @var array
     */
    protected $join = [];






    public function select($columnNames = '*')
    {
        if (is_string($columnNames)) {
            $columnNames = [$columnNames];
        }
        foreach ($columnNames as &$columnName) {
            $columnName = $this->escapeAliasedName($columnName);
        }
        unset($columnName);
        
        $this->select = $columnNames;
        
        return $this;
    }

    public function from($tableNames)
    {
        if (is_string($tableNames))
        {
            $tableNames = [$tableNames];
        }
        foreach ($tableNames as &$tableName) {// экранирует и конкретинирует
            $tableName = $this->escapeAliasedName($tableName);
        };
        
        unset($tableName);
        $this->from = $tableNames;
        
        return $this;
    }

    public function getText()
    {
        return 'select ' . join(', ', $this->select)
            . ' from ' . join(', ', $this->from)
            . join('', array_map(function ($array) {
                return ' join ' . $this->escapeAliasedName($array[0]) . ' ON ' . $this->formatCondition($array[1]);
            }, $this->join))
            . ' where' . $this->formatCondition($this->where);
    }

    /**
     * @param $name string
     * @return string
     * @throws Exception
     */
    protected function escapeAliasedName($name)
    {
        $name = str_ireplace(' AS ', ' ', $name);
        $parts = explode(' ', $name);
        $parts = array_filter($parts, function ($part) {
            return $part != '';
        });
        $count = (count($parts));
        if ($count == 1) {
            $name = Database::escapeName($parts[0]);
        } elseif ($count == 2) {
            $name = Database::escapeName($parts[0]) . ' as ' . Database::escapeName($parts[1]);
        } else {
            throw new Exception('Неверный формат имени таблицы');
        }
        return $name;
    }

    public function __construct($database) // метод принимающий и укладывающий
    {
        $this->database = $database;
    }

    protected function formatCondition($condition)
    {
        switch ($condition[0]) {
            case '=':
                $second = $condition[2] instanceof DatabaseExpression
                    ? $condition[2]->getEscapedValue()
                    : ('\'' . $this->database->connection->real_escape_string($condition[2]) . '\'');
                return Database::escapeName($condition[1]) . ' = ' . $second;
            case 'and':
                return join(' and ', array_map([$this, 'formatCondition'], array_slice($condition, 1)));
        }
        
        throw new Exception('Неподдерживаемый оператор');
    }

    public function where($condition)  // условия
    {
        $this->where = $condition;
        
        return $this;
    }

    public function getRows()
    {
        $query = $this->getText();
        $result = $this->database->sendQuery($query);
        
        return $result;
    }

    public function join($tableName, $condition)
    {
        $this->join[] = [$tableName, $condition];
        
        return $this;
    }
};