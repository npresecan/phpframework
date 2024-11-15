<?php

namespace App\Routers;

use App\Requests\Request;
use App\Responses\Response;

class Router
{
    private $routes = [];

    public function newRoute(string $url, string $method, callable $callback): void
    {
        $this->routes[] = [
            'url' => $url,
            'method' => strtoupper($method),
            'callback' => $callback
        ];
    }

    public function resolveRoute(Request $request): string
    {
        $url = $request->getPath();
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