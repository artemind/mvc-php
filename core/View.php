<?php
namespace core;
class View
{
    private static $instance = null;
    private $pathToViews = ROOT . "/views";
    private $layout;

    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone() {}
    private function __construct()
    {
        $this->setLayout("main");
    }

    public function setLayout($layout)
    {
        $this->layout = $this->pathToViews . "/layouts/$layout.php";
    }

    public function redirect($path) {
        header("Location: $path");
    }

    public function render($pathToView, $data = [])
    {
        $twig = App::getTwig();
        echo $twig->render($pathToView.".html",['brand'=>App::params('brand')] + $data + ['isGuest' => App::isGuest()]);
    }
}