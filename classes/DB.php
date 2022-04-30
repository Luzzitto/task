<?php

/**
 * Database Class by howCodeOrg
 * Youtube: https://www.youtube.com/watch?v=NLsbLB2Qgvg&list=PLBOh8f9FoHHhRk0Fyus5MMeBsQ_qwlAzG&index=2
 * Github: https://github.com/howCodeORG/Social-Network/blob/Part2/classes/DB.php
 */
class DB {
    private static function connect() {
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=task;charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function query($query, $params = array()) {
        $statement = self::connect()->prepare($query);
        $statement->execute($params);
        if (explode(" ", $query)[0] === "SELECT") {
            $data = $statement->fetchAll();
            return $data;
        }
    }

}