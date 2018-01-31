<?php
/**
 * Здесь возможно будет скрипт автозагрузки.
 * А пока - просто инклуды.
 *
 * @author dmtrpro
 */

define('ROOT_DIR', __DIR__);
define('TEMPLATE_DIR', ROOT_DIR.'/templates/');
define('APP_DIR', ROOT_DIR.'/src/');
define('CONFIG_DIR', ROOT_DIR.'/config/');
define('DATA_DIR', ROOT_DIR.'/data/');
define('UPLOADS_DIR', ROOT_DIR.'/public/uploads/');

define('CONFIG', [
    'site' => include CONFIG_DIR . 'site.config.php',
]);

/**
 * Composer autoloader
 */
//include_once APP_DIR . '/vendor/autoload.php';

/**
 * An example of a project-specific implementation.
 *
 * @link https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
 *
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'App\\';

    // base directory for the namespace prefix
    $base_dir = __DIR__ . '/src/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});