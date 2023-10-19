<?php

use Core\Response;
use Core\Session;

function dd($value): void
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';

    die();
}

function abort(int $errorCode = 404): void
{
    http_response_code($errorCode);

    require base_path("views/$errorCode.php");

    die();
}

function urlIs($value): bool
{
    return $_SERVER['REQUEST_URI'] === $value;
}

function authorize(bool $condition, $status = Response::FORBIDDEN): void
{
    if (!$condition) {
        abort($status);
    }
}

function base_path(string $path): string
{
    return BASE_PATH . $path;
}

function view(string $path, array $attributes = []): void
{
    extract($attributes);

    require base_path('views/' . $path);
}

function redirect(string $path): void
{
    header("location: $path");

    exit();
}

function old(string $key, string $default = ""): mixed
{
    return Session::get("old")[$key] ?? $default;
}