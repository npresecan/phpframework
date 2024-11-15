<?php

use App\Routers\Router;
use App\Requests\Request;
use App\Responses\Response;
use App\Controllers\IndexController;

$indexController = new IndexController();

$router->newRoute('/index', 'GET', function (Request $request): Response {
    return new Response('Praksa');
});

$router->newRoute('/dodaj', 'POST', function (Request $request): Response {
    $name = $request->getPostParam('name') ?? 'Gost';
    return new Response('Bok, ' . $name);
});

$router->newRoute('/index/response', 'GET', [$indexController, 'indexAction']);

$router->newRoute('/index/json', 'GET', [$indexController, 'indexJsonAction']);

$router->newRoute('/index/html', 'GET', [$indexController, 'indexHtmlAction']);

return $router;