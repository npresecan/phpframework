<?php

namespace App;

interface RequestInterface
{
    public function getQueryParam($key); 
    public function getPostParam($key); 
    public function getMethod();
}