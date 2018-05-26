# изменённое Readme из первоисточника
# Slim 3 Skeleton

This is a simple skeleton project for Slim 3 that includes Twig, Flash messages and Monolog.
Based on https://github.com/akrabat/slim3-skeleton

## Установка:
./install.sh

### Запуск:

1.Запускаем встроенный в php сервер `$ php -S localhost:8080 -t public public/index.php`

2.Открываем в браузере http://localhost:8080

3.Видим Slim логотип

## Key directories

* `app`: Application code
* `app/src`: All class files within the `App` namespace
* `app/templates`: Twig template files
* `cache/twig`: Twig's Autocreated cache files
* `log`: Log files
* `public`: Webserver root
* `vendor`: Composer dependencies

## Key files

* `public/index.php`: Entry point to application
* `app/settings.php`: Configuration
* `app/dependencies.php`: Services for Pimple
* `app/middleware.php`: Application middleware
* `app/routes.php`: All application routes are here
* `app/src/Action/HomeAction.php`: Action class for the home page
* `app/templates/home.twig`: Twig template file for the home page
