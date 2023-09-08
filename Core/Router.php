<?php

namespace Core;

class Router {
    protected $routes = [];

    protected function add(string $method, string $uri, string $controller): void
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method
        ];
//        $this->routes[] = compact('method', 'uri', 'controller');
    }

    public function get(string $uri, string $controller): void
    {
        $this->add( 'GET', $uri, $controller);
    }

    public function post(string $uri, string $controller): void
    {
         $this->add( 'POST', $uri, $controller);
    }

    public function delete(string $uri, string $controller): void
    {
         $this->add( 'DELETE', $uri, $controller);
    }

    public function patch(string $uri, string $controller): void
    {
         $this->add( 'PATCH', $uri, $controller);
    }

    public function put(string $uri, string $controller): void
    {
         $this->add( 'PUT', $uri, $controller);
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
