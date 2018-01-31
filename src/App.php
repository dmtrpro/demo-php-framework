<?php

namespace App;

class App
{
    public static $CONFIG = [];

    public function __construct()
    {
        self::$CONFIG = [
            'site' => include CONFIG_DIR . 'site.config.php',
        ];
    }
}
