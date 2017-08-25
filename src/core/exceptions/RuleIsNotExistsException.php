<?php
namespace app\core\exceptions;

class RuleIsNotExistsException extends \Exception {
	public function __construct($message = "", $code = 0, Exception $previous = null) {
		$tmp = explode("\\",__CLASS__);
		$className = end($tmp);
		if(empty($message)) {
			$message = "Validate rule is not exists.";
		}
		$message = "$className: $message";
		parent::__construct($message, $code, $previous);
	}
}