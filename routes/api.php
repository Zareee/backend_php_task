<?php

require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\Router;



$router = new Router();

foreach (glob(__DIR__ . '/../routes/custom/*.php') as $filename) {
  include_once $filename;
}


$requestUri = parse_url($_SERVER['PATH_INFO'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];


$router->handle($requestUri, $requestMethod);

