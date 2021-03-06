<?php


abstract class ActiveRecord
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string[]
     */
    public $errorMessages;

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

    public function getValidationRules()
    {
        return [];
    }

    public function isValid()
    {
        $this->errorMessages = [];
        $result = true;

        foreach ($this->getValidationRules() as $rule) {
            $name = $rule['field'];
            $params = isset($rule['params']) ? $rule['params'] : [];
            $result = $result && call_user_func([$rule['validator'], 'isValid'], $this->$name, $params, $this);
        }

        return $result;
    }

    public function save()
    {
        if (!$this->isValid()) {
            return false;
        }
        
        $database = Application::getInstance()->db;
        $fields = $this->getFields();
        $tableName = $database->escapeName($this->getTableName());
        $params = $database->formatSetQueryPart($fields);

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

        return true;
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

    public function __get($name)
    {
        $methodName = 'get'. ucfirst($name);

        if (method_exists($this, $methodName)) {
            return call_user_func([$this, $methodName]);
        }
        
        if (in_array($name, static::getColumnNames())) {
            return null;
        }

        throw new Exception('Не найдено свойство в объекте');
    }

    public function __set($name, $value)
    {
        $methodName = 'set'. ucfirst($name);
        if (method_exists($this, $methodName)) {
            call_user_func([$this, $methodName], $value);

            return;
        }
        
        if (in_array($name, static::getColumnNames())) {
            $this->$name = $value;
        } else {
            throw new Exception('Не найдено свойство ' . $name . ' в объекте');
        }
    }

    public function getFieldLabels()
    {
        return [];
    }

    public function addErrorMessage($message)
    {
        $this->errorMessages[] = $message;
    }
}