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
            $pattern = $this->convertRouteToRegex($route['url']);

            if (preg_match($pattern, $url, $matches) && strtoupper($route['method']) == $method) {
                array_shift($matches);
                $_REQUEST['route_params'] = $matches;

                $response = call_user_func_array($route['callback'], $matches);

                if ($response instanceof Response) {
                    return $response->send(); 
                }
            }
        }

        $response = new Response('Not Found', 404);
        return $response->send();
    }

    private function convertRouteToRegex(string $route): string
    {
        return '#^' . preg_replace('/{([a-zA-Z0-9_]+)}/', '(?P<$1>[^/]+)', $route) . '$#';
    }
}