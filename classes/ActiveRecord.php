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

    public function __construct($isNew = true)
    {
        if ($isNew) {
            $this->init();
        }
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
            $activeRecord = new static(false);
            $activeRecord->oldId = $row['id'];
            foreach ($row as $name => $value) {
                $activeRecord->$name = $value;
            }
            $activeRecords[] = $activeRecord;
        }

        return $activeRecords;
    }

    protected function init()
    {
        $columnNames = static::getColumnNames();
        foreach ($columnNames as $name) {
            $this->$name = null;
        }
    }


    /**
     * @param $id
     * @return static
     */
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
        $fields = $this->getFields();
        $tableName = $database->escapeName($this->getTableName());
        $params = $database->formatSetQueryPart($fields);

        if (isset($this->oldId)) {
            $oldId = $database->connection->real_escape_string($this->oldId);
            $query = 'UPDATE ' . $tableName . ' SET ' . $params . ' WHERE id = ' . $oldId;
        } else {
            $query = 'REPLACE INTO ' . $tableName . ' SET ' . $params;
        }

        $database->sendQuery($query);
        if (!isset($this->oldId)) {
            $this->id = $database->connection->insert_id;
        }
        
        $this->oldId = $this->id;
    }

    /**
     * @return string[]
     */
    public static function getColumnNames()
    {
        return array_column(static::getColumns(), 'Field');
    }

    public static function getColumns()
    {
        $tableName = static::getTableName();
        $database = Application::getInstance()->db;

        return $database->sendQuery('SHOW COLUMNS FROM ' . $database->escapeName($tableName));
    }

    /**
     * @return array ассоциативный массив, где ключи имена столбцов, а значения - значения одноименных св-в модели.
     */
    public function getFields()
    {
        $columnNames = static::getColumnNames();
        $flippedColumns = array_flip($columnNames);
        return array_intersect_key((array)$this, $flippedColumns);
    }

    public function delete()
    {
        if (is_null($this->oldId)) {
            throw new Exception('не существует существует объекта в базе');
        }
        
        $database = Application::getInstance()->db;
        $tableName = static::getTableName();
        $oldId = $database->connection->real_escape_string($this->oldId);
        $database->sendQuery('DELETE FROM ' . $database->escapeName($tableName) . ' WHERE id = ' . $oldId);
        $this->oldId = null;
    }
}