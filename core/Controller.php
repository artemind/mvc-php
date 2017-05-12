<?php
namespace core;
class Controller
{
    protected $view;

    public function __construct() {
        $this->view = View::getInstance();
    }
}