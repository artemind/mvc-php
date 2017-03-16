<?php
namespace controllers;
use \core\App;
class UserController extends \core\Controller
{

    public function actionLogout() {
        if(!App::isGuest()) {
            \core\App::logout();
        }
        return $this->view->redirect('/');

    }

    public function actionLogin() {
        if(!App::isGuest()) {
            return $this->view->redirect('/');
        }

        if(isset($_POST['login'])) {
            //todo form is submitted
            die;
        }
        return $this->view->render("user/login");
    }


    public function actionSignup() {
        if(!App::isGuest()) {
            return $this->view->redirect('/');
        }
        if(isset($_POST['signup'])) {
            //form is submitted
            die;
        }
        return $this->view->render("user/signup");
    }
}