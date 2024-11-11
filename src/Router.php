<?php

namespace App;

class Router
{
    private $routes = [];

    public function newRoute($url, $method, $callback)
    {
        $this->routes[] = [
            'url' => $url,
            'method' => $method,
            'callback' => $callback
        ];
    }

    public function resolveRoute($url, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['url'] === $url && $route['method'] === $method) {
                return call_user_func($route['callback']);
            }
        }

        return "404 - Not found";
    }
}