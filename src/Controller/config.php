<?php

namespace CerfaReceiptsGen\Controller;

class Config {
    private static $config;

    /**
     * Retrieves the app CONSTs
     * 
     * @param string $key The app CONST name to retrieve.
     * @param mixed $default [OPTIONAL] Default value to return if the $key is not found in the
     * app CONSTs.
     * 
     * @return mixed The value of the specified key from the configuration. If the key does not exist
     * or is empty, it will return the default value provided.
     */
    public static function get(string $key, $default = null) {
        if (is_null(self::$config)) {
            self::$config = require_once(__DIR__ . '/../../config.php');
        }

        if (!empty(self::$config[$key])) return self::$config[$key];
        else if (!empty($_ENV[$key])) return $_ENV[$key];
        return $default;
    }
}