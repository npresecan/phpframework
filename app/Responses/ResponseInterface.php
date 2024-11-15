<?php

namespace App\Responses;

interface ResponseInterface
{
    public function send(): string;
}