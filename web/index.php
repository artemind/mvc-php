<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
define("ROOT", $_SERVER['DOCUMENT_ROOT']);
require_once(ROOT."/vendor/autoload.php");

use \core\App;
use \core\Router;
use \core\Controller;
use \core\exceptions\IsNotSetAppKeyException;
$controller = new Controller();

try {
	$appCode = App::params('APP_KEY');
	if(empty($appCode) || $appCode === null) {
		throw new IsNotSetAppKeyException();
	}
	(new Router())->run();
} catch(Exception $ex) {
	$controller->getErrorPage($ex->getMessage(), 'Ошибка!!!', 'danger');
}
