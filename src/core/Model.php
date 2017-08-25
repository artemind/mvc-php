<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.03.2017
 * Time: 10:23
 */

namespace app\core;


use ReCaptcha\ReCaptcha;
use core\App;
use core\exceptions\RuleIsNotExistsException;

class Model
{

    public function validate()
    {
        $rules = $this->rules();
        foreach ($rules as $rule) {
            if (!is_array($rule[0]) || is_array($rule[1])) {
                return false;
            }
            switch ($rule[1]) {
                case "required":
                    foreach ($rule[0] as $r) {
                        if (!isset($this->$r) || $this->$r === '') {
                            return false;
                        }
                    }
                    break;
                case 'email':
                    foreach ($rule[0] as $r) {
                        if (!filter_var($this->$r, FILTER_VALIDATE_EMAIL) === true) {
                            return false;
                        }
                    }
                    break;
                case 'equals':
                    if($this->$rule[0][0] !== $this->$rule[0][1]) {
                        return false;
                    }
                    break;
                case 'unique':
                    $tmp = is_string($this->$rule[0][0]) ? "'".$this->$rule[0][0]."'" : $this->$rule[0][0];
                    $q = "SELECT ".$rule[0][0]. " FROM ".$this->tableName() . " WHERE "
                        .$rule[0][0]. "=".$tmp." LIMIT 1";
                    $conn = DB::getConnection();
                    $res = $conn->query($q)->fetch(\PDO::FETCH_ASSOC);
                    if($res !== false) {
                        return false;
                    }
                    break;
                case 'captcha':
                    $reCaptcha = new ReCaptcha(App::params('reCaptchaSecret'));
                    $response = $reCaptcha->verify(
                        $this->captcha,
                        $_SERVER["REMOTE_ADDR"]
                    );
                    if (!$response->isSuccess()) {
                        return false;
                    }
                    break;
                default:
                    throw new RuleIsNotExistsException("Validate rule \"{$rule[1]}\" is not exists.");
            }
        }
        return true;
    }


    public function rules()
    {
        return [];
    }

}