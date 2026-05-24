<?php

declare(strict_types=1);

namespace App;

final class Router
{
    /** @var array<string, array{0: class-string, 1: string}> */
    private array $routes = [];

    public function get(string $route, array $handler): void
    {
        $this->routes['GET'][$route] = $handler;
    }

    public function post(string $route, array $handler): void
    {
        $this->routes['POST'][$route] = $handler;
    }

    public function dispatch(string $route, string $method): void
    {
        $handler = $this->routes[$method][$route] ?? null;
        if ($handler === null) {
            http_response_code(404);
            view('errors.404', ['title' => 'Page not found']);
            return;
        }
        [$class, $action] = $handler;
        $controller = new $class();
        $controller->$action();
    }
}
