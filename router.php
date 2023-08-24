<?php

$routes = require('routes.php');
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

function routeToController($uri, $routes): void {
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        abort();
    }
}

function abort(int $errorCode = 404): void {
    http_response_code($errorCode);

    require "views/$errorCode.php";

    die();
}

routeToController($uri, $routes);