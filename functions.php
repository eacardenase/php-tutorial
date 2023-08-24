<?php

function dd($value): void {
    echo '<pre>';
    var_dump($value);
    echo '</pre>';

    die();
}

function urlIs($value): bool {
    return $_SERVER['REQUEST_URI'] === $value;
}

function authorize(bool $condition, $status = Response::FORBIDDEN): void {
    if (!$condition) {
        abort($status);
    }
}