<?php
namespace app\controllers;
class DefaultController extends \app\core\Controller
{

    public function actionIndex() {
        return $this->view->render("default/index");
    }
}