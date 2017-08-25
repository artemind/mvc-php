<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
define("ROOT", $_SERVER['DOCUMENT_ROOT']);
require_once(__DIR__."/../vendor/autoload.php");

use app\core\App;
use app\core\Controller;
use app\core\exceptions\IsNotSetAppKeyException;
use app\core\Router;


try {
	$appCode = App::params('APP_KEY');
	if(empty($appCode) || $appCode === null) {
		throw new IsNotSetAppKeyException();
	}
	(new Router())->run();
} catch(Exception $ex) {
	(new Controller())->getErrorPage($ex->getMessage(), 'Ошибка!!!', 'danger');
}
