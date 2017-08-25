<?php

namespace app\core;
use \app\core\exceptions\KeyIsNotExistsException;

/**
* Класс предназначен для хранения и управления 
* конфигурацией приложения.
*/
class Params {
	private static $instance;
	private $params;

	/**
	* Инициализирует переменную $params
	*/
	private function init() {
		$this->params = include(App::config_path('/params.php'));
	}

	private function __construct() {
		$this->init();
	}

	private function __clone() {}

	public static function getInstance() {
		if(empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function setParam($key, $value, $override = false) {
		if(key_exists($key, $this->params) && !$override) {
			return false;
		}
		$this->params[$key] = $value;
	}

	public function getParam($key) {
		if(!key_exists($key, $this->params)) {
			throw new KeyIsNotExistsException("Параметр \"$key\" не существует!");
		}
		return $this->params[$key];
	}

	public function getParams() {
		return $this->params;
	}
}