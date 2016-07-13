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

    /**
     * @var int
     */
    protected $limit;

    /**
     * @var int
     */
    protected $skip;

    /**
     * @var string[]
     */
    protected $group = [];

    /**
     * @var array
     */
    protected $order = [];






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
        $selectBlock = 'select ' . join(', ', $this->select);
        $fromBlock = $this->from ? ' from ' . join(', ', $this->from) : '';
        $joinBlock = join('', array_map(function ($array) {
            return ' join ' . $this->escapeAliasedName($array[0]) . ' ON ' . $this->formatCondition($array[1]);
        }, $this->join));
        $whereBlock = $this->where ? ' where' . $this->formatCondition($this->where) : '';

        $limitBlock = '';

        if (isset($this->limit) && is_null($this->skip)) {
            $limitBlock = ' limit ' . $this->limit;
        } elseif (isset($this->skip)) {
            $limit = isset($this->limit) ? $this->limit : 4294967295; // 4294967295 - 32битная система, макс кол-во строк
            $limitBlock = ' limit ' . $this->skip . ', ' . $limit;
        }
        
        $groupBlock = $this->group ? ' group by ' . join(', ', array_map(function ($columnName) {
            return Database::escapeName($columnName);
        }, $this->group)) : '';

        $orderBlock = $this->order ? ' order by ' . join(', ', array_map(function ($rule) {
            if (is_array($rule)) {
                $direction = $rule[1];
                $columnName = Database::escapeAnyName($rule[0]);
            } else {
                $direction = 'ASC';
                $columnName = Database::escapeAnyName($rule);
            }

            return $columnName . ' ' . $direction;
            }, $this->order)) : '';

        return $selectBlock
            . $fromBlock
            . $joinBlock
            . $whereBlock
            . $groupBlock
            . $orderBlock
            . $limitBlock;
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

    /**
     * @param $limit int|float|string число возвращаемых рядов
     * @return $this
     */
    public function limit($limit)
    {
        if (!is_numeric($limit)) {
            throw new InvalidArgumentException('Не верный формат данных');
        }
            $this->limit = (int)$limit;

        return $this;
    }

    /**
     * @param $skip int|float|string число offset
     * @return $this
     */
    public function skip($skip)
    {
        if (!is_numeric($skip)) {
            throw new InvalidArgumentException('Не верный формат данных');
        }
        $this->skip = (int)$skip;

        return $this;
    }

    /**
     * @param $columnNames string[]|string
     * @return $this
     */
    public function group($columnNames)
    {
        if (is_string($columnNames))
        {
            $columnNames = [$columnNames];
        }
        $this->group = $columnNames;
        
        return $this;
    }

    /**
     * @param $rules array
     * @return $this
     */
    public function order($rules)
    {
        $this->order = $rules;

        return $this;
    }
};