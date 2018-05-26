<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 17.11.17
 * Time: 4:06
 */

namespace App\Controllers;

use App\Models\User;
use App\Models\Site;
use Respect\Validation\Validator as v;

class UserController extends Controller
{
    public function user($request, $response, $args){

        return $this->container->view->render($response, 'user.twig');
    }

    public function directLogin($request, $response, $args){
        $_SESSION['user'] = $args['id'];
        return $response->withRedirect($this->router->pathFor('home'));
    }

    public function read($request, $response, $args)
    {
        if ($args['id'] <= 0) return 'Неверный id';

        $user = User::findOrFail($args['id']);
        return $response->withJson($user);
    }

    public function list($request, $response, $args){
        $role = $this->container->role->getUserRole();
        $user = $this->container->auth->user();
        if (empty($args['id'])) {
            if ($role->role_name === 'admin') {
                return $response->withJson(User::all());
            }
            else {
                $sites = Site::where('owner_id', $user->id)->get();
                $output = array();
                foreach ($sites as $site) {
                    $users = User::where('site_id', $site->id)->get();
                    foreach ($users as $user) {
                        array_push($output, $user);
                    }
                }
                return $response->withJson($output);
            }
        }
        return $response->withJson(User::findorFail($args['id']));
    }

    public function getCreate($request, $response)
    {
        return $this->container->view->render($response, 'user/create.twig');
        //return $response->withRedirect($this->router->pathFor('user.create'));
    }

    public function postCreate($request, $response)
    {
        $validation = $this->validator->validate($request, [
            'login'    => v::noWhitespace()->notEmpty()->loginAvailable(),
            'password' => v::noWhitespace()->notEmpty(),
            'last_name' => v::noWhitespace()->notEmpty(),
            'first_name' => v::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed()){
            return $response->withRedirect($this->router->pathFor('user.create'));
        }

        $user = User::create([
            'login' => $request->getParam('login'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT), //, ['cost' => 10]),
            'last_name' => $request->getParam('last_name'),
            'first_name' => $request->getParam('first_name'),
            'info' => $request->getParam('info'),
            'is_blocked' => $request->getParam('is_blocked'),
            'department_id' => $request->getParam('department_id'),
            'role_id' => $request->getParam('role_id'),
            'site_id' => $request->getParam('site_id')
        ]);
        return "id: " . (string)$user['id'];
    }


    public function update($request, $response, $args)
    {
        if ($args['id'] <= 0) return 'Неверный id';

        $user = User::findOrFail($args['id']);//where('id', $args['id'])->first();
        $user->login = $request->getParam('login');
        $user->password = password_hash($request->getParam('password'), PASSWORD_DEFAULT); //, ['cost' => 10]);
        $user->last_name = $request->getParam('last_name');
        $user->first_name = $request->getParam('first_name');
        $user->info = $request->getParam('info');
        $user->is_blocked = $request->getParam('is_blocked');
        $user->department_id = $request->getParam('department_id');
        $user->role_id = $request->getParam('role_id');
        $user->site_id = $request->getParam('site_id');

        $user->save();
        return (string)$user['id'];
    }

    public function delete($request, $response, $args)
    {
        if ($args['id'] <= 0) return 'Неверный id';

        $user = User::findOrFail($args['id']);
        $user->delete();
        return 'Удаление успешно';
    }
    
    //Метод нужен был для выпадающего списка Владелец сайта, возможно надо будет доработать т.к.
    // если запрос от дамина, то он может посмотреть пользователей по role_id,
    // но если от владельца сайта - он же и возвращается. 
    public function role($request, $response, $args){
        $user = $this->auth->user();

        if ($args['id'] <= 0)
            return 'incorrect id';
        //админ
        if ($user->role_id == 2) {
            $users = User::where('role_id', $args['id'])->get();
            return $response->withJson($users);
        }
        //владелец сайта
        elseif ($user->role_id == 1){
            $users[] = $user; //на странице ожидается массив, поэтому даже 1 юзера ложим в массив
            return $response->withJson($users);
        }
    }
}