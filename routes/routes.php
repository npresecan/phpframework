<?php

use App\Routers\Router;
use App\Requests\Request;
use App\Responses\Response;
use App\Controllers\IndexController;
use App\Controllers\UserController;

$indexController = new IndexController();

$userController = new UserController();

$router->newRoute('/user/create', 'POST', [$userController, 'create']);

$router->newRoute('/user/{id}', 'GET', [$userController, 'read']);

$router->newRoute('/user/update/{id}', 'POST', [$userController, 'update']);

$router->newRoute('/user/delete/{id}', 'POST', [$userController, 'delete']);


$router->newRoute('/index', 'GET', [$indexController, 'index']);

$router->newRoute('/dodaj', 'POST', [$indexController, 'dodaj']);

$router->newRoute('/index/response', 'GET', [$indexController, 'indexAction']);

$router->newRoute('/index/json', 'GET', [$indexController, 'indexJsonAction']);

$router->newRoute('/index/html', 'GET', [$indexController, 'indexHtmlAction']);

return $router;