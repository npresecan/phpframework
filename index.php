<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Router;
use App\Request;

$router = new Router();
$request = new Request();

require_once __DIR__ . '/../routes.php';

$router->resolveRoute($request);