<?php

namespace App;

class Request implements RequestInterface
{
    public function getQueryParam($key)
    {
        return $_GET[$key] ?? null;
    }
    
    public function getPostParam($key)
    {
        return $_POST[$key] ?? null;
    }
    
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}