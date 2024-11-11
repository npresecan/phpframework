<?php

namespace App;

use App\Response;

class Router
{
    private $routes = [];

    public function newRoute($url, $method, $callback)
    {
        $this->routes[] = [
            'url' => $url,
            'method' => strtoupper($method),
            'callback' => $callback
        ];
    }

    public function resolveRoute(Request $request)
    {
        $url = $_SERVER['REQUEST_URI'];
        $method = $request->getMethod();

        foreach ($this->routes as $route) {
            if ($route['url'] == $url && $route['method'] == $method) {
                $response = call_user_func($route['callback'], $request);
                if ($response instanceof Response) {
                    return $response->send();
                }
            }
        }

        $response = new Response('Not Found', 404);
        return $response->send();
    }
}