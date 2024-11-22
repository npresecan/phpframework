<?php

namespace App\Requests;

interface RequestInterface
{
    public function getQueryParam(string $key): ?string;
    public function getPostParam(string $key): ?string;
    public function getMethod(): string;
    public function getPath(): string;
    public function getRouteParams(): array;
}