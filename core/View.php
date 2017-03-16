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
        $pathToView = $this->pathToViews . "/" . $pathToView . ".php";
        if (!file_exists($pathToView) || !file_exists($this->layout)) {
//            throw new HttpException("Страница не найдена", 404);
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
            return false;
        }
        extract($data);
        include($this->layout);
    }
}