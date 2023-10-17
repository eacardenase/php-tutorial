<?php

namespace Core\Middleware;

class Middleware
{
    public const MAP = [
        "guest" => Guest::class,
        "auth" => Auth::class
    ];

    public static function resolve(string|null $key): void
    {
        if (!$key) {
            return;
        }

        $middleware = static::MAP[$key] ?? false;

        if (!$middleware) {
            throw new  \Exception("No found matching middleware for key '$key'.");
        }

        (new $middleware)->handle();
    }
}