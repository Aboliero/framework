<?php

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
     * @param array $options
     * @return string
     */
    public function select($name, $options)
    {
        $head = '<select name="' . htmlspecialchars($name) . '" id="' . htmlspecialchars($name) . '">';
        $body = [];
        $modelValue = $this->model->$name;
        foreach ($options as $option => $text) {
            $body[] = '<option ' . ($option == $modelValue ? 'selected ' : '') . 'value="' . htmlspecialchars($option) . '">' . htmlspecialchars($text) . '</option>';
        }
        $end = '</select>';

        return $head . join('', $body) . $end;
    }

    
    

//    public function bottom()
//    {
//
//    }
}