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

  /*  public function getSignInBasic($request, $response)
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Текст';
            exit;
        }
        else return $this->container->view->render($response, 'login.twig');
    }
*/
    public function postSignInBasic($request, $response)
    {
    /*    if (!isset($_SERVER['PHP_AUTH_USER']) || isset($_SERVER['PHP_AUTH_PW']))
            return $response->withRedirect($this->router->pathFor('auth.signin.basic'));
*/
        $user = $_SERVER['PHP_AUTH_USER'];
        $pass = $_SERVER['PHP_AUTH_PW'];

        $auth = $this->auth->attempt(
            $request->getParam('login'),
            $request->getParam('password')
        );

        //$auth = $this->auth->attempt($user, $pass);

        if (!$auth){
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'false';
            exit;
        }
        die("true");
    }

    public function getSignOut($request, $response)
    {
        $this->auth->logout();
        return $response->withRedirect($this->router->pathFor('home'));
    }


}
