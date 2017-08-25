<?php

namespace app\core;
use \app\core\exceptions\KeyIsNotExistsException;

/**
* Класс предназначен для хранения и управления 
* конфигурацией приложения.
*/
class Params {
	private static $params;

	/**
	* Инициализирует переменную $params
	*/
	private static function init() {
	    if(!isset(self::$params)) {
            self::$params = include(App::config_path('/params.php'));
        }

	}

	private function __construct() {}

	private function __clone() {}

	public static function setParam($key, $value, $override = false) {
	    self::init();
		if(key_exists($key, self::$params) && !$override) {
			return false;
		}
		self::$params[$key] = $value;
	}

	public static function get($key) {
        self::init();
		if(!key_exists($key, self::$params)) {
			throw new KeyIsNotExistsException("Параметр \"$key\" не существует!");
		}
		return self::$params[$key];
	}

	public static function getParams() {
        self::init();
		return self::$params;
	}
}