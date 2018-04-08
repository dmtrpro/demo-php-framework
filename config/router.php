<?php

use Framework\Router\Router;

$router = new Router();

$router->get('home', '/', 'App\Controller\MainController::indexAction');

$router->get('productSingle', '/{product}', 'App\Controller\MainController::singleAction');

return $router;