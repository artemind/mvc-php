<?php
namespace controllers;
class DefaultController extends \core\Controller
{

    public function actionIndex() {
        return $this->view->render("default/index");
    }
}