<?php

define('APP_DIR', __DIR__);
define('TEMPLATE_DIR', APP_DIR.'/templates/');
define('SOURCE_DIR', APP_DIR.'/src/');
define('CONFIG_DIR', APP_DIR.'/config/');
define('DATA_DIR', APP_DIR.'/data/');
define('UPLOADS_DIR', APP_DIR.'/public/uploads/');

define('CONFIG', [
    'site' => include CONFIG_DIR.'site.config.php',
]);

try {
    require_once 'src/autoload.php';

} catch (\Exception $e){
    echo 'Oups! Error #'.$e->getCode().': '.$e->getMessage();
}