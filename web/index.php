<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
define("ROOT", $_SERVER['DOCUMENT_ROOT']);
require_once(ROOT."/vendor/autoload.php");

(new \core\Router())->run();