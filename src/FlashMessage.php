<?php
class FlashMessage {
    const SESSION_KEY = "flash-message";

    public static function get(string $key, $defaultValue = "") {
        $value = $_SESSION[self::SESSION_KEY][$key]??$defaultValue;
        self::unset($key);
        return $key;
    }

    public static function set(string $key, $value) {
        $_SESSION[self::SESSION_KEY][$key] = $value;
    }

    private static function unset(string $key) {
        unset($_SESSION[self::SESSION_KEY][$key]);
    }
}