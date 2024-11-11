<?php

use App\Router;
use App\Request;
use App\Response;

$router = new Router();

$router->newRoute('GET', '/index', function($request) {
    return new Response('Praksa');
});

$router->newRoute('POST', '/dodaj', function($request) {
    $name = $request->getPostParam('name');
    return new Response('Hello, ' . $name);
});

return $router;