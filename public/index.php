<?php

use App\App;
use Framework\Middleware\ErrorHandlerMiddleware;
use Framework\Middleware\RoutingMiddleware;
use Zend\Diactoros\ServerRequestFactory;

include_once dirname(__DIR__).'/autoload.php';

$container = require CONFIG_DIR . '/services.php';
$router = require CONFIG_DIR . '/router.php';

$app = new App($container);

$app->add(ErrorHandlerMiddleware::class);
$app->add(new RoutingMiddleware($container, $router));

$request = ServerRequestFactory::fromGlobals();
$response = $app->handle($request);

$app->emit($response);