<?php

require __DIR__ . '/vendor/autoload.php';

use App\Routers\Router;
use App\Requests\Request;

$router = new Router();
$request = new Request();

require_once __DIR__ . '/routes/routes.php';

$router->resolveRoute($request);