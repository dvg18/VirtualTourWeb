<?php

// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

$dotenv = new Dotenv\Dotenv(__DIR__ .'/..');
$dotenv->load();
$dotenv->required(array('DB_HOST', 'DB_DATABASE', 'DB_USERNAME'));


// Instantiate the app
$settings = require __DIR__ . '/../app/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../app/dependencies.php';

// Register routes
require __DIR__ . '/../app/routes.php';

$container = $app->getContainer();

$app->add(new App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new App\Middleware\OldInputMiddleware($container));
//$app->add(new App\Middleware\CsrfViewMiddleware($container));
//$app->add($container->csrf);

// Run!
$app->run();
