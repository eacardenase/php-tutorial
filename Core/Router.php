<?php

namespace Core;

class Router {
    protected $routes = [];

    public function get(string $uri, string $controller): void
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => 'GET'
        ];
    }

    public function post(string $uri, string $controller): void
    {
         $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => 'POST'
        ];
    }

    public function delete(string $uri, string $controller): void
    {
         $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => 'DELETE'
        ];
    }

    public function patch(string $uri, string $controller): void
    {
         $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => 'PATCH'
        ];
    }

    public function put(string $uri, string $controller): void
    {
         $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => 'PUT'
        ];
    }

    public function route(string $uri, string $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                return require base_path($route['controller']);
            }
        }

        $this->abort();
    }

    protected function abort(int $errorCode = 404): void
    {
        http_response_code($errorCode);

        require base_path("views/$errorCode.php");

        die();
    }
}
