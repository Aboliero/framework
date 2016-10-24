<?php


abstract class ActiveRecord
{
    /**
     * @var int
     */
    public $id;

    /**
     * @return string
     */
    public static function getTableName()
    {
        return '';
    }

    /**
     * @param $condition
     * @param $limit
     * @return static[]
     */
    public static function getObjects($condition = null, $limit = null)
    {
        $activeRecords = [];
        $query = new Query(Application::getInstance()->db);
        $query->select()->from(static::getTableName());
        if ($condition) {
            $query->where($condition);
        }
        if ($limit) {
            $query->limit($limit);
        }
        $rows = $query->getRows();
        foreach ($rows as $row) {
            $activeRecord = new static;
            foreach ($row as $name => $value) {
                $activeRecord->$name = $value;
            }
            $activeRecords[] = $activeRecord;
        }

        return $activeRecords;
    }

    public static function getById($id)
    {
        $objects = static::getObjects(['=', 'id', $id], 1);
        if ($objects) {
            return array_shift($objects);
        }
        
        return null;
    }

    public function save()
    {
        $database = Application::getInstance()->db;
        $fields = (array)$this;
        $keys = array_keys($fields);
        $values = array_values($fields);
        $params = join(', ', array_map(function($key, $value) use ($database) {
            return $database->escapeName($key)
                . ' = '
                . "'" . $database->connection->real_escape_string($value) . "'";
        }, $keys, $values));

        $id = $database->connection->real_escape_string($this->id);
        $tableName = $database->escapeName($this->getTableName());
        $query = 'UPDATE ' . $tableName . ' SET ' . $params . ' WHERE id = ' . $id;
        $database->sendQuery($query);
    }
}