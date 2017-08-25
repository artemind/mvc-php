<?php
namespace app\core;
class Controller
{
    protected $view;

    public function __construct() {
        $this->view = View::getInstance();
    }

    public function getErrorPage($message, $title = "Ошибка!", $type = 'default') {
    	$title = trim(strip_tags($title));
        $message = trim(strip_tags($message));
        $types = trim(strip_tags($type));
        $types = [
            'default',
            'primary',
            'success',
            'info',
            'danger',
            'warning',
        ];
        if(!in_array($type, $types)) {
            $type = 'default';
        }
    	$this->view->render('errors/index', compact('message', 'title', 'type'));
    	return false;
    }
}