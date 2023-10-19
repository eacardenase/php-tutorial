<?php

namespace Core;

use Core\Middleware\Guest;
use Core\Middleware\Auth;
use Core\Middleware\Middleware;

class Router
{
    protected $routes = [];

    protected function add(string $method, string $uri, string $controller): Router
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];

        return $this;
    }

    public function get(string $uri, string $controller): Router
    {
        return $this->add('GET', $uri, $controller);
    }

    public function post(string $uri, string $controller): Router
    {
        return $this->add('POST', $uri, $controller);
    }

    public function delete(string $uri, string $controller): Router
    {
        return $this->add('DELETE', $uri, $controller);
    }

    public function patch(string $uri, string $controller): Router
    {
        return $this->add('PATCH', $uri, $controller);
    }

    public function put(string $uri, string $controller): Router
    {
        return $this->add('PUT', $uri, $controller);
    }

    public function only(string $key): Router
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;

        return $this;
    }

    public function route(string $uri, string $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                Middleware::resolve($route["middleware"]);

                return require base_path("Http/controllers/{$route['controller']}");
            }
        }

        $this->abort();
    }

    public function previousUrl(): string
    {
        return $_SERVER["HTTP_REFERER"];
    }

    protected function abort(int $errorCode = 404): void
    {
        http_response_code($errorCode);

        require base_path("views/$errorCode.php");

        die();
    }
}
