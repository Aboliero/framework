<?php

abstract class Controller // запрещает создание экземпляра этого класса
{

    public $defaultActionName = 'default';
    /**
     * @var Application
     */
    public $app;
    public function execute($actionName = null)
    {
        if (is_null($actionName)) {
            $actionName = $this->defaultActionName;
        }
        $methodName = $actionName . 'Action';
        if (!method_exists($this, $methodName)) {
            throw new exception('Нет такого действия!');
        };
        $this->$methodName();
    }

    public function getName()
    {
        $parts = explode('\\', get_class($this));
        $className = array_pop($parts); // конец ебучего квеста по наводу порядка в этой системе. Ебать, запомнить надо.
        $controllerName = substr($className, 0, strrpos($className, 'Controller'));

        return $controllerName;
    }

    public function render($localViewName, $data = [])
    {
        $globalViewName = $this->getName() . '/' . $localViewName;

        $content = $this->simpleRender($globalViewName, $data);

        echo $this->simpleRender('layout', ['content' => $content]);
    }

    public function simpleRender($globalViewName, $data = [])
    {
        $__fileName = 'views/' . $globalViewName . '.php';
        if (!file_exists($__fileName)) {
            throw new Exception('Нет такого представления!');
        }
        extract($data);

        ob_start();
        include $__fileName;

        return ob_get_clean();
    }


}

//. $this->getName() . '/'