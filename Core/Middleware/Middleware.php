<?php

namespace Core\Middleware;

use Core\Middleware\Auth;
use Core\Middleware\Guest;

class Middleware

{

    public const MAP = [
        'guest' => Guest::class,
        'auth' => Auth::class,
        'confirmed' => Confirmed::class
    ];

    public static function resolve($key)
    {
        if (!$key) {
            return;
        }
        if (!array_key_exists($key, static::MAP)) {
            throw new \Exception("un supported middleware {$key}", 1);
        }
        $middleware = static::MAP[$key];
        (new $middleware)->handle();
    }
}
