<?php

use App\Routers\Router;
use App\Requests\Request;
use App\Responses\Response;

$router->newRoute('/index', 'GET', function (Request $request): Response {
    return new Response('Praksa');
});

$router->newRoute('/dodaj', 'POST', function (Request $request): Response {
    $name = $request->getPostParam('name') ?? 'Gost';
    return new Response('Bok, ' . $name);
});

return $router;