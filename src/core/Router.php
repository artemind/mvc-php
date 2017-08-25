<?php

namespace core;
class Router
{
    private $routes;

    public function __construct() {
        $this->routes = include(App::config_path('/routes.php'));
    }

    /**
     * returns request string
     * @return string
     */
    private function getURI() {
        if(!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], "/");
        }
    }

    public function run() {
        $uri = $this->getURI();
        foreach($this->routes as $uriPattern => $path) {
            if(preg_match("~^$uriPattern$~", $uri)) {
                $internalRoute = preg_replace("~^$uriPattern$~", $path, $uri);
                $params = explode("/", $internalRoute);
                $controllerName = ucfirst(array_shift($params))."Controller";
                $actionName = "action" . ucfirst(array_shift($params));
                $controllerName = "\\controllers\\".$controllerName;
                $controller = new $controllerName;
                $res = call_user_func_array([$controller, $actionName], $params);
                return true;
            }
        }
        header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        return false;
    }

}