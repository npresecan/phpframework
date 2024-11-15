<?php

namespace App\Requests;

class Request implements RequestInterface
{
    public function getQueryParam(string $key): string
    {
        return $_GET[$key] ?? null;
    }

    public function getPostParam(string $key): string
    {
        return $_POST[$key] ?? null;
    }

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getPath(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function getRouteParams(): array
    {
        return $_REQUEST['route_params'] ?? [];
    }
}