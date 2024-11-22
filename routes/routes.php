<?php

use App\Routers\Router;
use App\Requests\Request;
use App\Responses\Response;
use App\Controllers\IndexController;

$indexController = new IndexController();


$router->newRoute('/index', 'GET', [$indexController, 'index']);

$router->newRoute('/dodaj', 'POST', [$indexController, 'dodaj']);

$router->newRoute('/index/response', 'GET', [$indexController, 'indexAction']);

$router->newRoute('/index/json', 'GET', [$indexController, 'indexJsonAction']);

$router->newRoute('/index/html', 'GET', [$indexController, 'indexHtmlAction']);

return $router;