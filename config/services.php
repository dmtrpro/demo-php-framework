<?php

use Framework\Middleware\ErrorHandler;
use Framework\Middleware\ErrorHandlerMiddleware;
use Framework\Middleware\NotFoundHandler;
use Framework\Middleware\RoutingMiddleware;
use Framework\Renderer\PhpRenderer;
use Framework\Renderer\RendererInterface;
use League\Container\Container;

$container = new Container();

$container->delegate(
    new League\Container\ReflectionContainer()
);

$container->add(RendererInterface::class, PhpRenderer::class);

$container->add('DefaultHandler', NotFoundHandler::class)->withArgument(RendererInterface::class);

/** Middlewares **/

$container->add(ErrorHandlerMiddleware::class)->withArgument(RendererInterface::class);

return $container;