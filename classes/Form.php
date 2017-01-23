<?php

/*<input name="name" id="name" value="<?= $city->name ?>">
**/
class Form
{
    /**
     * @var ActiveRecord
     */
    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function open($method = 'get')
    {
        return '<form method="' . $method . '"">';
    }

    public function close()
    {
        return '</form>';
    }

    public function input($name)
    {
        $value = $this->model->$name;
        
        return $this->_input($name, $value);
    }

    protected function _input($name, $value)
    {
        
        return '<input name="' . htmlspecialchars($name) . '" id="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '">';
    }

    public function unemployInput($name)
    {
        $value = $this->model->$name;
        return '<input name="' . htmlspecialchars($name) . '" id="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value)* 100 . '">';
    }

    public function dateInput($name)
    {
        /** @var DateTime $date */
        $date = $this->model->$name;
        $value = $date ? $date->format('d.m.Y') : '';
        
        return $this->_input($name, $value);
    }

    public function label($name)
    {
        $labels = $this->model->getFieldLabels();
        $label = isset($labels[$name]) ? $labels[$name] : $name;
        
        return '<label for="' . $name . '">' . $label . '</label>';
    }

    /**
     * @param $name
     * @param $options ActiveRecord[]
     * @param $id 
     * @param string $identy  имя опшиона по свойства объекта
     * @return string
     */
    public function select($name, $id, $identy, $options)
    {
        $body = [];
        $head = '<select name="' . $name . '" id="' . $name . '">';
        foreach ($options as $option) {
            $value = $option->$id;
            $optionName = $option->$identy;
            $body[] = '<option ' . ($value == $this->model->$name ? 'selected ' : '') . 'value="' . $value . '">' . $optionName . '</option>';
                }
        $end = '</select>';

        return $head . join('', $body) . $end;
    }

//    public function bottom()
//    {
//
//    }
}