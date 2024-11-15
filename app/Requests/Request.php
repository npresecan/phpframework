<?php

namespace App\Requests;

class Request implements RequestInterface
{
    public function getQueryParam(string $key): ?string
    {
        return $_GET[$key] ?? null;
    }

    public function getPostParam(string $key): ?string
    {
        return $_POST[$key] ?? null;
    }

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        return strtok($path, '?');
    }
}