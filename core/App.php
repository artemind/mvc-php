<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.03.2017
 * Time: 21:37
 */

namespace core;


use Twig_Environment;
use Twig_Loader_Filesystem;

class App
{

    private static $twig = null;

    public static function getTwig() {
        if(empty(self::$twig)) {
            $loader = new Twig_Loader_Filesystem(self::params('pathToViews'));
            self::$twig = new Twig_Environment($loader, [
                'debug' => true,
            ]);
        }
        return self::$twig;
    }

    private static $params;

    public static function params($key) {
        if(!isset(self::$params)) {
            self::$params = include("/../config/params.php");
        }
        return isset(self::$params[$key]) ? self::$params[$key] : null;
    }


    public static function isGuest() {
        if(!isset($_SESSION['email'])|| !isset($_SESSION['firstname'])
            || !isset($_SESSION['surname'])) {
            return true;
        }
        return false;
    }

    public static function login($user) {
        $_SESSION['email'] = $user->email;
        $_SESSION['firstname'] = $user->firstname;
        $_SESSION['surname'] = $user->surname;
        return true;
    }

    public static function logout() {
        session_unset();
    }

    public static function getCssPath() {
        return ROOT."/web/css/";
    }

}