<?php

class DB {
    private static function connect() {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=test;", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    public static function query($query, $params = array()) {
        $s = self::connect()->prepare($query);
        $s->execute($params);
        if (explode(' ', $query)[0] == "SELECT") {
            $data = $s->fetchAll();
            return $data;
        }
    }
}