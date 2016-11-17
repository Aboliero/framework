<?php


abstract class ActiveRecord
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    protected $oldId;

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
            $activeRecord->oldId = $row['id'];
            foreach ($row as $name => $value) {
                $activeRecord->$name = $value;
            }
            $activeRecords[] = $activeRecord;
        }

        return $activeRecords;
    }

    public static function getById($id)
    {
        $condition = ['=', 'id', $id];
        
        return static::getObject($condition);
    }

    public static function getObject($condition)
    {
        $objects = static::getObjects($condition, 1);
        if ($objects) {
            return array_shift($objects);
        }

        return null;
    }

    public function save()
    {
        $database = Application::getInstance()->db;
        $fields = (array)$this;
        unset($fields[chr(0) . '*' . chr(0) . 'oldId']);
        $tableName = $database->escapeName($this->getTableName());
        $keys = array_keys($fields);
        $values = array_values($fields);
        $params = join(', ', array_map(function($key, $value) use ($database) {
            if (is_null($value)) {
                $sqlValue = 'NULL';
            } else {
                $sqlValue = "'" . $database->connection->real_escape_string($value) . "'";
            }

            return $database->escapeName($key) . ' = ' . $sqlValue;
        }, $keys, $values));

        if (isset($this->oldId)) {
            $oldId = $database->connection->real_escape_string($this->oldId);
            $query = 'UPDATE ' . $tableName . ' SET ' . $params . ' WHERE id = ' . $oldId;
        } else {
            $query = 'INSERT INTO ' . $tableName . ' SET ' . $params;
        }

        $database->sendQuery($query);
        if (!isset($this->oldId)) {
            $this->id = $database->connection->insert_id;
        }
        
        $this->oldId = $this->id;
    }
}