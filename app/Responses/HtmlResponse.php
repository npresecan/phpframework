<?php

namespace App\Responses;

class HtmlResponse extends Response
{
    public function __construct(string $content, int $statusCode = 200)
    {
        parent::__construct($content, $statusCode);
        header('Content-Type: text/html; charset=utf-8');
    }
}