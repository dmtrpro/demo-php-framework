<?php

define('ROOT_DIR', __DIR__);
define('RESOURCES_DIR', ROOT_DIR . '/resources');
define('TEMPLATE_DIR', RESOURCES_DIR . '/templates');
define('APP_DIR', ROOT_DIR . '/src');
define('CONFIG_DIR', ROOT_DIR . '/config');
define('DATA_DIR', ROOT_DIR . '/data');
define('PUBLIC_DIR', ROOT_DIR . '/public');
define('UPLOADS_DIR', PUBLIC_DIR . '/uploads');

define('CONFIG', [
    'site' => include CONFIG_DIR . 'site.config.php',
]);

/**
 * Composer autoloader
 */
include_once ROOT_DIR . '/vendor/autoload.php';