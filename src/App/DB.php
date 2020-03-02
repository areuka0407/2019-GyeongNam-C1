<?php
namespace App;

class DB {
    static $conn = null;
    static function getDB(){
        $options = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];
        if(self::$conn === null){
            self::$conn = new \PDO("mysql:host=localhost;dbname=2019_gyeongnam_c1;charset=utf8mb4", "root", "", $options);
        }
        return self::$conn;
    }

    static function query($sql, $data = []){
        $q = self::getDB()->prepare($sql);
        $q->execute($data);
        return $q;
    }

    static function fetch($sql, $data = [], $fetchMode = \PDO::FETCH_OBJ){
        return self::query($sql, $data)->fetch($fetchMode);
    }

    static function fetchAll($sql, $data = [], $fetchMode = \PDO::FETCH_OBJ){
        return self::query($sql, $data)->fetchAll($fetchMode);
    }

    static function find($table, $id){
        return self::fetch("SELECT * FROM `$table` WHERE id = ?", [$id]);
    }


}