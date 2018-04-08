<?php

use App\Repository\ProductRepository;
use Framework\DB\Database;
use Framework\DB\MySqlDatabase;
use Framework\DB\SqLiteDatabase;
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

$container->add(Database::class, SqLiteDatabase::class)->withArgument([
    'file' => 'shop.sqlite'
]);

/** Renderers */

$container->add(RendererInterface::class, PugRenderer::class)->withArgument([
    'expressionLanguage' => 'js',
]);

$container->add('twig', TwigRenderer::class);

/** Middlewares **/

$container->add('DefaultHandler', NotFoundHandler::class)->withArgument(RendererInterface::class);

$container->add(ErrorHandlerMiddleware::class)->withArgument(RendererInterface::class);

/** Repositories **/

//$container->add(ProductRepository::class, ProductRepository::class)
//    ->withArgument(Database::class);

return $container;