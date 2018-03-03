<?php

use Framework\Router\Router;

$router = new Router();

$router->get('galleryIndex', '/', 'App\Presentation\Controller\GalleryController::indexAction');

$router->get('gallerySingle', '/{image}', 'App\Presentation\Controller\GalleryController::singleAction');

return $router;