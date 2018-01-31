<?php

use App\Presentation\Controller\GalleryController;

try {
    include_once '../autoload.php';

    $controller = new GalleryController();

    if ($_GET['image']) {
        echo $controller->singleAction();
    } elseif (isset($_GET['generate'])) {
        echo $controller->generateAction();
    } else {
        echo $controller->indexAction();
    }

} catch (\Exception $e) {
    echo 'Oups! Error #' . $e->getCode() . ': ' . $e->getMessage();
}