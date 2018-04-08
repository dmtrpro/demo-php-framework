<?php

use Framework\Router\Router;

$router = new Router();

$router->get('home', '/', 'App\Controller\MainController::indexAction');

$router->get('productsCart', '/cart', 'App\Controller\MainController::cartAction');

$router->get('productsCheckout', '/checkout', 'App\Controller\MainController::checkoutAction');

$router->get('productsCatalog', '/products', 'App\Controller\ProductController::indexAction');

$router->get('productsCatalogJson', '/products.json', 'App\Controller\ProductController::indexAction')
    ->addAttribute('type', 'json');

$router->get('productsSingle', '/products/{product}', 'App\Controller\MainController::singleAction');

return $router;