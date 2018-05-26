<?php
// DIC configuration

use Respect\Validation\Validator as v;

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Twig
$container['view'] = function ($container) {
    $settings = $container->get('settings')['view'];
    $view = new Slim\Views\Twig($settings['template_path'], $settings['twig'], [
        'cache' => false,
    ]);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension(
        $container->get('router'), // $container->router, the same
        $container->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'user' => $container->auth->user(),
    ]);

    $view->getEnvironment()->addGlobal('flash', $container->flash);

    $view->getEnvironment()->addGlobal('role', [
        'all' => $container->role->getRoles(),
    ]); //, $container->role);

    $view->getEnvironment()->addGlobal('department', [
        'all' => $container->department->getDepartments(),
    ]);

    $view->getEnvironment()->addGlobal('site', [
        'all' => $container->site->getSites(),
    ]);
    return $view;
};

// Flash messages
$container['flash'] = function ($c) {
    return new Slim\Flash\Messages;
};
$container['csrf'] = function ($container) {
    return new \Slim\Csrf\Guard;
};
$container['auth'] = function ($container) {
    return new App\Classes\Auth;
};
$container['role'] = function ($container) {
    return new App\Classes\Role;
};
$container['department'] = function ($container) {
    return new App\Classes\Departments;
};
$container['site'] = function ($container) {
    return new App\Classes\Sites;
};
$container['validator'] = function ($container) {
    return new App\Classes\Validation\Validator();
};

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

v::with('App\\Classes\\Validation\\');

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'] . ";charset=UTF8",
        $settings['user'], $settings['pass'],
        array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    return $pdo;

};
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db1']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db1'] = function ($container) use ($capsule) {
    return $capsule;
};

//Controllers

$container['HomeController'] = function ($container) {
    return new App\Controllers\HomeController($container);
};

$container['AuthController'] = function ($container) {
    return new App\Controllers\AuthController($container);
};

$container['SiteController'] = function ($container) {
    return new App\Controllers\SiteController($container);
};

$container['OperatorController'] = function ($container) {
    return new App\Controllers\OperatorController($container);
};

$container['UserController'] = function ($container) {
    return new App\Controllers\UserController($container);
};

$container['DepartmentController'] = function ($container) {
    return new App\Controllers\DepartmentController($container);
};

$container['SiteController'] = function ($container) {
    return new App\Controllers\SiteController($container);
};