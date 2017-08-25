<?php
namespace core\exceptions;

class IsNotSetAppKeyException extends \Exception {

	public function __construct($message = "", $code = 0, Exception $previous = null) {
		if(empty($message)) {
			$tmp = explode("\\",__CLASS__);
			$className = end($tmp);
			$message = "$className: Вы не установили ключ приложения. Добавьте этот элемент в массив параметров приложения <pre>\"APP_KEY\" => \"".md5(uniqid())."\"</pre>";
		}
		parent::__construct($message, $code, $previous);
	}
}