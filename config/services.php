<?php

use Framework\DB\Database;
use Framework\DB\MySqlDatabase;
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

/** DataBase */

$container->add(Database::class, MySqlDatabase::class)->withArgument(CONFIG['db']);

/** Renderers */

$container->add(RendererInterface::class, PugRenderer::class)->withArgument([
    'expressionLanguage' => 'js',
]);

$container->add('twig', TwigRenderer::class);

/** Middlewares **/

$container->add('DefaultHandler', NotFoundHandler::class)->withArgument(RendererInterface::class);

$container->add(ErrorHandlerMiddleware::class)->withArgument(RendererInterface::class);

return $container;