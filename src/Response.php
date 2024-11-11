<?php

namespace App;

class Response implements ResponseInterface
{
    private $content;
    private $statusCode;
    
    public function __construct(string $content = '', int $statusCode = 200)
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
    }
    
    public function setContent(string $content)
    {
        $this->content = $content;
    }
    
    public function getContent(): string
    {
        return $this->content;
    }
    
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }
    
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
    
    public function send(): string
    {
        http_response_code($this->statusCode);
        echo $this->content;
    
        return $this->content;
    }
}