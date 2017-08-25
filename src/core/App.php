<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.03.2017
 * Time: 21:37
 */

namespace app\core;


use Twig_Environment;
use Twig_Loader_Filesystem;
use \app\config\Params as appParams;

class App
{
    private $cssPath = "/css/";
    private $jsPath = "/js/";
    private $imgPath = "/img/";

    private static $twig = null;

    public static function getTwig()
    {
        if (empty(self::$twig)) {
            $loader = new Twig_Loader_Filesystem(self::params('pathToViews'));
            self::$twig = new Twig_Environment($loader, [
                'debug' => self::params("APP_DEBUG"),
            ]);
        }
        return self::$twig;
    }

    private static $params;

    /**
     * @param $key
     * Возвращает значение параметра приложения
     * @see /config/params.php
     * @return mixed|null
     */
    public static function params($key)
    {
        if(!isset(self::$params)) {
            self::$params = appParams::getInstance();
        }
        return self::$params->getParam($key);
    }

    /**
     * Проверяет пользователя на авторизованность
     * @return bool
     */
    public static function isGuest()
    {
        if (!isset($_SESSION['email']) || !isset($_SESSION['firstname'])
            || !isset($_SESSION['surname'])
        ) {
            return true;
        }
        return false;
    }

    /**
     * @param $user
     * авторизация пользователя
     * @return bool
     */
    public static function login($user)
    {
        $_SESSION['email'] = $user->email;
        $_SESSION['firstname'] = $user->firstname;
        $_SESSION['surname'] = $user->surname;
        return true;
    }

    public static function logout()
    {
        session_unset();
    }

    /**
     * @param string $to
     * Если параметр $to не указан, то метод возвращает массив всех
     * полей, в названии которых есть постфикс Path.
     * Если параметр $to указан, метод возвращает поле с именем $to+Path,
     * в противном случае - null
     * @return array|string|null
     */
    public static function getPath($to = "")
    {
        $to = trim(strip_tags($to));
        $obj = new self();
        $result = [];
        foreach ($obj as $key => $val) {
            if(!empty($to)) {
                if(preg_match("/^{$to}Path$/", $key)) {
                    return $val;
                }
            } else if (preg_match("/^\\w*Path$/", $key)) {
                $result[$key] = $val;
            }
        }
        if(!empty($to)) {
            return null;
        }
        return $result;
    }



    public static function config_path($child = "") {
        return ROOT . "/../config$child";
    }

    public static function views_path($child = "") {
        $path = substr(self::params('pathToViews'), 0, -1); //delete last "/"
        return $path . $child;
    }

}