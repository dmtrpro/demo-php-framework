<?php

use Framework\Middleware\ErrorHandlerMiddleware;
use Framework\Middleware\NotFoundHandler;
use Framework\Renderer\PugRenderer;
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRenderer;
use League\Container\Container;

$container = new Container();

$container->delegate(
    new League\Container\ReflectionContainer()
);

$container->add(RendererInterface::class, PugRenderer::class)->withArgument([
    'expressionLanguage' => 'js',
]);

$container->add('twig', TwigRenderer::class);

$container->add('DefaultHandler', NotFoundHandler::class)->withArgument('twig');

/** Middlewares **/

$container->add(ErrorHandlerMiddleware::class)->withArgument('twig');

return $container;