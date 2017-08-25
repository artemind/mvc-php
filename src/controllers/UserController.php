<?php
namespace app\controllers;
use \app\core\App;
use \app\models\LoginForm;
class UserController extends \app\core\Controller
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
            $form = new LoginForm();
            $form->email = $_POST['email'];
            $form->password = $_POST['password'];
            if($form->login()) {
                $this->view->redirect("/");
                die;
            }
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