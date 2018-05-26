<?php
return [
    'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => getenv('DEV'),

        // View settings
        'view' => [
            'template_path' => __DIR__ . '/templates',
            'twig' => [
                'cache' => __DIR__ . '/../cache/twig',
                'debug' => getenv('DEV'),
                'auto_reload' => true,
            ],
        ],

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/../log/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        "db" => [
            "host" => getenv('DB_HOST'),
            "dbname" => getenv('DB_DATABASE'),
            "user" => getenv('DB_USERNAME'),
            "pass" => getenv('DB_PASSWORD')
        ],
        'db1' => [
            'driver' => 'mysql',
            'host' => getenv('DB_HOST'),
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ],
];
