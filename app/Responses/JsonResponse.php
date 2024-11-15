<?php

namespace App\Responses;

class JsonResponse extends Response
{
    public function __construct($data = null, int $statusCode = 200)
    {
        if ($data !== null) {
            $data = json_encode($data); 
        } else {
            $data = json_encode(['message' => 'No content']);
        }
        
        header('Content-Type: application/json');
        
        parent::__construct($data, $statusCode);
    }
    
    public function send(): string
    {
        http_response_code($this->getStatusCode());
        echo $this->getContent();

        return $this->getContent();
    }
}