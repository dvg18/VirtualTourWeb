<?php
/**
 * Created by PhpStorm.
 * User: reghi
 * Date: 27.10.2017
 * Time: 15:51
 */

namespace App\Controllers;

use App\Classes\Role;

class HomeController extends Controller
{

    public function index($request, $response)
    {
        //$this->logger->info("Home page action dispatched");
        if (!$this->auth->check())
            return $response->withRedirect($this->router->pathFor('auth.signin'));

        $role = Role::getUserRole()->role_name;

        switch ($role) {
            case 'admin' :
                return $response->withRedirect($this->router->pathFor('user.list'));
            case 'user' :
                return $response->withRedirect($this->router->pathFor('collection.list'));
            default :
                return $response->withRedirect($this->router->pathFor('auth.signout')); //нужно направить на какую-нибудь страницу с ошибкой
        }
    }
}
