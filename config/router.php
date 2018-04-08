<?php

use Framework\Router\Router;

$router = new Router();

$router->get('home', '/', 'App\Controller\MainController::indexAction');

$router->get('productsCart', '/cart', 'App\Controller\MainController::cartAction');

$router->get('productsCheckout', '/checkout', 'App\Controller\MainController::checkoutAction');

$router->get('productsCatalog', '/products', 'App\Controller\MainController::catalogAction');

$router->get('productsSingle', '/products/{product}', 'App\Controller\MainController::singleAction');

return $router;