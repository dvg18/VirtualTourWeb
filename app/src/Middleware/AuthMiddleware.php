<?php
/**
 * Created by PhpStorm.
 * User: reghi
 * Date: 01.11.2017
 * Time: 5:38
 */

namespace App\Middleware;

class AuthMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {

        if (!$this->container->auth->check()){
            $this->container->flash->addMessage('error', 'Пожалуйста, авторизуйтесь');
            return $response->withRedirect($this->container->router->pathFor('auth.signin'));
        }

        $response = $next($request, $response);
        return $response;
    }

}