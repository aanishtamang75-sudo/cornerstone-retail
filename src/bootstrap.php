<?php

declare(strict_types=1);

session_start();

define('BASE_PATH', dirname(__DIR__));
define('PUBLIC_PATH', BASE_PATH . '/public');

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    $baseDir = BASE_PATH . '/src/';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }
    $relative = str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    $file = $baseDir . $relative;
    if (is_file($file)) {
        require $file;
    }
});

require BASE_PATH . '/src/helpers.php';

$dbConfig = require BASE_PATH . '/config/database.php';

App\Database::init($dbConfig);
