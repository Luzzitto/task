<?php

class Input {
    public static function sanitize($data) {
        return htmlspecialchars(htmlentities(strip_tags($data)));
    }
    public static function doesExist($var) {
        if (isset($var) && !empty($var)) {
            return true;
        }
        return false;
    }
}