<?php
/**
 * Created by PhpStorm.
 * User: reghi
 * Date: 01.11.2017
 * Time: 3:24
 */

namespace App\Middleware;

class CsrfViewMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {

        $this->container->view->getEnvironment()->addGlobal('csrf',[
            'field' => '
                <input type="hidden" name="'.$this->container->csrf->getTokenNameKey().'"
                value="'.$this->container->csrf->getTokenName().'">
                <input type="hidden" name="'.$this->container->csrf->getTokenValueKey().'"
                value="'.$this->container->csrf->getTokenValue().'">
            ',
        ]);

        $response = $next($request, $response);
        return $response;
    }
}