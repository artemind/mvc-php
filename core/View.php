<?php
namespace core;
class View
{
    private $pathToViews = ROOT . "/views";
    private $layout;

    public function __construct()
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
        echo $twig->render($pathToView.".html",$data + ['isGuest' => App::isGuest()]);
    }
}