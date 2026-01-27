<?php

namespace App\Helpers;

class Hook
{
    protected static array $hooks = [];

    public static function add(string $key, callable|string $callback, int $priority = 10)
    {
        self::$hooks[$key][$priority][] = $callback;
    }

    public static function render(string $key, ...$params)
    {
        $output = '';

        if (!isset(self::$hooks[$key])) return $output;

        ksort(self::$hooks[$key]);

        foreach (self::$hooks[$key] as $priority => $callbacks) {
            foreach ($callbacks as $cb) {
                $result = is_callable($cb)
                    ? call_user_func_array($cb, $params)
                    : $cb;

                $output .= $result;
            }
        }

        return $output;
    }

    public static function all()
    {
        $rendered = [];

        foreach (self::$hooks as $key => $callbacks) {
            $rendered[$key] = self::render($key);
        }

        return $rendered;
    }
}
