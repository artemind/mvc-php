<?php
namespace core\exceptions;

class KeyIsNotExistsException extends \Exception {
	public function __construct($message = "", $code = 0, Exception $previous = null) {
		$tmp = explode("\\",__CLASS__);
		$className = end($tmp);
		if(empty($message)) {
			$message = "Такого элемента нет в массиве!";
		}
		$message = "$className: $message";
		parent::__construct($message, $code, $previous);
	}
}