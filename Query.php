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
     * @param $name string неэкранированное имя
     * @return string экранированное имя
     */
    
    protected function escapePartialName($name) // экранирование частей имени
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
    protected function escapeName($name)
    {
        $names = explode('.', $name);
        $names = array_map ([$this, 'escapePartialName'], $names); // синтаксис collable
        $names = join('.', $names);
        return $names;

    }

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
        return 'select ' . join(', ', $this->select) . ' from ' . join(', ', $this->from);
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
            $name = $this->escapeName($parts[0]);
        } elseif ($count == 2) {
            $name = $this->escapeName($parts[0]) . ' as ' . $this->escapeName($parts[1]);
        } else {
            throw new Exception('Неверный формат имени таблицы');
        }
        return $name;
    }
};