<?php
namespace app\models;


use app\core\Model;

class LoginForm extends Model {

	public function rules() {
		return [
			[['email', 'password'], 'required'],
			[['email'], 'email'],
		];
	}

	public function login() {
		if($this->validate()) {
			//TODO реализовать этот метод
			return true;
		} else {
			return false;
		}
	}
}