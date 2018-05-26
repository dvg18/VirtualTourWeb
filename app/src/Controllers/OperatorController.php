<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.11.17
 * Time: 0:25
 */

namespace App\Controllers;

use App\Models\Site;
use App\Models\User;
use Symfony\Component\Config\Definition\Exception\Exception;

class OperatorController extends Controller
{
    public function dropdownOperator($request, $response){
        if (!$request->isXhr()){
            return false;
        }
        //Авторизуемся для проверки запроса.
        //admin     admin  - владелец системы
        //owner1    owner  - владелец сайта
        //operator1 operator

//        $this->auth->attempt("owner1", "owner");

        $user = null;
        if($this->auth->check()){
            $user = $this->auth->user();
        }
        else{
            return "no permission";
        }

        if (($user->role_id != 1) && ($user->role_id != 2 )) {
            return "no permission";
        }

        try{
            $site_id_exist = isset($_GET['site_id']);
            $department_id_exist = isset($_GET['department_id']);

            //если владелец системы
            if($user->role_id == 2) {
                //если передали site_id и department_id
                if ($site_id_exist && $department_id_exist) {
                    $site_id = $_GET['site_id'];
                    $department_id = $_GET['department_id'];
                    //Добавил site_id в выборку, возможно это лишнее, ведь department_id всё равно уникальный относительно всех сайтов
                    $operators = User::whereRaw('role_id = 3  AND department_id = '. $department_id.' AND site_id = '.$site_id)->get();
                }
                //если передали только site_id
                elseif ($site_id_exist && !$department_id_exist) {
                    $site_id = $_GET['site_id'];
                    $operators = User::whereRaw('role_id = 3 AND site_id='.$site_id)->get();
                }
                //если ничего не передали, вывести просто всех операторов
                elseif (!$site_id_exist && !$department_id_exist){
                    $sites = Site::all();
                    $operators = [];
                    foreach ($sites as $site){
                        $operators_by_site = User::whereRaw('role_id = 3 AND site_id=' . $site->id)->get();
                        foreach($operators_by_site as $operator){
                            $operators[] = $operator;
                        }
                    }
                }
                
                return json_encode($operators);
            }
            //если владелец сайта
            if($user->role_id == 1) {
                if ($site_id_exist && $department_id_exist) {
                    $site_id = $_GET['site_id'];
                    $department_id = $_GET['department_id'];
                    $operators = User::whereRaw('role_id = 3  AND department_id = '. $department_id.' AND site_id = '.$site_id)->get();
                }
                elseif ($site_id_exist && !$department_id_exist) {
                    $site_id = $_GET['site_id'];
                    $operators = User::whereRaw('role_id = 3 AND site_id=' . $site_id)->get();
                }
                //если не передали сайт, берём все сайты владельца, возвращаем их операторов
                else {
                    $sites = Site::where('owner_id', $user->id)->get();
                    $operators = [];
                    foreach ($sites as $site){
                        $operators_by_site = User::whereRaw('role_id = 3 AND site_id=' . $site->id)->get();
                        foreach ($operators_by_site as $operator){
                            $operators[] = $operator;
                        }
                    }
                }
                return json_encode($operators);
            }
        }
        catch (Exception $e){
            $output ="";
            $output['error']['code'] = 404;
//            $output['error']['message'] = "ID not found";
            $json_data['error']['message'] = $e->getMessage();
            return json_encode($output);
        }
    }
    public function redirectOperator($request, $response){

        //$user = null;
        //if($this->auth->check()) // эта проверка будет нужна, если путь не будет защищен middleware
            $user = $this->auth->user();
        //else return "no permission";

        if ($user->role_id != 3) {                                          //для админа у нас пока исключение в middleware,
            $this->flash->addMessage('error', 'Вы не оператор');
            return $response->withRedirect($this->router->pathFor('home')); //поэтому его нужно откидывать
        }
        return $response->withRedirect(
            getenv('PATH_OPERATOR').'?id='.$user->id.'&name='.$user->first_name.'&site_id='.$user->site_id,
            301);
    }
}