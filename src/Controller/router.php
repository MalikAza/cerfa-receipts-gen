<?php

namespace CerfaReceiptsGen\Controller;

class Router {
    public static function on($expression, $callback) {
        $params = !str_starts_with($_SERVER['REQUEST_URI'], '/') ?
            '/' . $_SERVER['REQUEST_URI'] :
            $_SERVER['REQUEST_URI'];

        $expression = str_replace('/', '\/', $expression);
        $matched = preg_match('/^' . $expression . '$/', $params, $matches, PREG_OFFSET_CAPTURE);

        if ($matched) {
            array_shift($matches);

            $params = array_map(function($param) {return $param[0];}, $matches);
            $callback(new Request($params), new Response());
        }
    }

    public static function get($route, $callback) {
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') !== 0) {
            return;
        }

        self::on($route, $callback);
    }
}