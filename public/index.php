<?php

use Framework\Kernel;
use Framework\Middleware\ErrorHandlerMiddleware;
use Framework\Middleware\RoutingMiddleware;
use Zend\Diactoros\ServerRequestFactory;

include_once __DIR__.'/../autoload.php';

$container = require CONFIG_DIR . '/services.php';
$router = require CONFIG_DIR . '/router.php';

$kernel = new Kernel($container);

$kernel->add(ErrorHandlerMiddleware::class);
$kernel->add(new RoutingMiddleware($container, $router));

$request = ServerRequestFactory::fromGlobals();
$response = $kernel->handle($request);

$kernel->emit($response);