<?php

namespace func;

abstract class Core
{
    use Component;

    public $layout = "main";
    public $title = 'Разработка Моргана';
    public $err = [];

    public function __construct(
        protected $db = false,
        protected $chpu = false
    )
    {
        $this->init();
    }

    protected function init()
    {
        if (!$this->isAuth()) {
            $this->redirect('login');
        }

        $this->beforeActions();
    }

    /**
     * return void
     * Можно выполнит какое-то действие перед Экшенс
     */
    protected function beforeActions():void
    {
        // ****************************** | action | ********
        $_chpy = isset($this->chpu[1]) ? $this->chpu[1] : false;
        $actions = [
            'update',
            'delete',
        ];
        if (in_array($_chpy, $actions)) {
            if (!$this->isAdmin())
                include_once 'views/forbidden.php';

        }
    }

    /**
     * @param $view
     * @param array $vars
     */
    public function render($view, $vars = [])
    {
        extract($vars);
        $path = 'views/' . strtolower($this->getClass()) . '/' . $view . '.php';
        if (file_exists($path)) {
            ob_start();
            require_once $path;
            $content = ob_get_clean();
            require_once 'views/layouts/' . $this->layout . '.php';

        } else {
            echo 'File not found: ' . $path;
        }
    }

    public function renderPart($view, $vars = [])
    {
        extract($vars);
        $path = 'views/' . strtolower($this->getClass()) . '/' . $view . '.php';
        if (file_exists($path)) {
            require_once $path;
        } else {
            echo 'File not found: ' . $path;
        }
    }

    public function redirect($to): void
    {
        header('Location:' . HOST . '/' . $to);
    }

    public function getClass(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     * @param $value
     * @return string
     */
    protected function old($value): string
    {
        return $_POST[$value] ?? false;
    }

}