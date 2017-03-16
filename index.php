<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
define("ROOT", __DIR__);
require_once("/vendor/autoload.php");

(new \core\Router())->run();