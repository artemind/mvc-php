<?php
namespace core;
class DB
{
    public static function getConnection() {
        $params = require(ROOT."/config/db.php");
        extract($params);
        return new \PDO("mysql:host=$host;dbname=$db", $user, $password);
    }
}