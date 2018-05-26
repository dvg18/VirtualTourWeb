<?php
/**
 * Created by PhpStorm.
 * User: reghi
 * Date: 01.11.2017
 * Time: 5:38
 */

namespace App\Middleware;


class RoleMiddleware extends Middleware
{
    protected $role;
    public function __construct($container, $role)
    {
        $this->role = $role;
        parent::__construct($container);
    }
    public function __invoke($request, $response, $next)
    {
        $userRole = $this->container->role->getUserRole()->role_name;
        if ($userRole != $this->role && $userRole != 'admin'){
            //TODO Some logic for admin
            $this->container->flash->addMessage('error', "У вас недостаточно прав просматривать эту страницу");
            return $response->withRedirect($this->container->router->pathFor('home'));
        }
        $response = $next($request, $response);
        return $response;
    }

}