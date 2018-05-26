<?php
/**
 * Created by PhpStorm.
 * User: reghi
 * Date: 27.10.2017
 * Time: 15:51
 */

namespace App\Controllers;

use Respect\Validation\Validator as v;

class AuthController extends Controller
{
    public function getSignIn($request, $response)
    {
        return $this->container->view->render($response, 'login.twig');
    }

    public function postSignIn($request, $response)
    {
        $validation = $this->validator->validate($request, [
            'login'    => v::noWhitespace()->notEmpty(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);

        /*if ($validation->failed()){
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }*/

        $auth = $this->auth->attempt(
            $request->getParam('login'),
            $request->getParam('password')
        );

        if (!$auth){
            $this->flash->addMessage('error', 'Ошибка авторизации!');
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }

        return $response->withRedirect($this->router->pathFor('home'));
    }

    public function getSignOut($request, $response)
    {
        $this->auth->logout();
        return $response->withRedirect($this->router->pathFor('home'));
    }
}
