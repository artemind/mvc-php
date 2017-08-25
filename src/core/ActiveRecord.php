<?php

namespace app\core;


abstract class ActiveRecord extends Model
{

    abstract public function tableName();


    public function save()
    {
        if(!$this->validate()) {
            return false;
        }
        $query = "INSERT INTO ".$this->tableName()." (";
        $fields = "";
        $values = "";
        foreach($this as $var => $val) {
            if(!isset($val) || stripos($var, "_repeat") !== false
                || $var == 'captcha') {
                continue;
            }
            $fields .= "$var,";
            $flag = is_string($val);
            if($flag) {
                $values .= "'$val',";
            } else {
                $values .= "$val,";
            }
        }
        if(!$fields || !$values) {
            return false;
        }
        //remove last ","
        $fields = substr($fields, 0, -1);
        $values = substr($values, 0, -1);
        $query .= "$fields) VALUES ($values)";
        $conn = DB::getConnection();
        $conn->query($query);
        return true;
    }

    public static function all($table) {
        $conn = DB::getConnection();
        return $conn->query("SELECT * FROM $table");
    }

    public function selectAll() {
        return self::all(self::tableName());
    }
}