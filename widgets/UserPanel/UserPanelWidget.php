<?php

class UserPanelWidget
{
    /**
     * @var Application $app
     */
    public $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function run()
    {
        return $this->render('userPanel');
    }

    public function render($viewName, $data = [])
    {
        $__fileName = __DIR__ . '/' . $viewName . '.php';
        if (!file_exists($__fileName)) {
            throw new Exception('Я не знаю как ты это сделал, нет такого представления!');
        }
        extract($data);

        ob_start();
        include $__fileName;

        return ob_get_clean();
    }
}