<?php

declare(strict_types=1);

abstract class Registry
{
    public const LOGGER = "logger";
    public const PDO = "PDO";

    private static array $services = [];

    private static array $allowedKeys = [
        self::LOGGER,
        self::PDO
    ];

    public static function set(string $key, Service $value)
    {
        if (!in_array($key, self::$allowedKeys)) {
            throw new InvalidArgumentException("Invalid key given");
        }

        self::$services[$key] = $value;
    }

    public static function get(string $key)
    {
        if (!in_array($key, self::$allowedKeys) || !isset(self::$services[$key])) {
            throw new InvalidArgumentException("Invalid key given");
        }

        return self::$services[$key];
    }

    public static function getPDO() {

    }
}