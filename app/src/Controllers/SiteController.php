<?php
namespace App\Controllers;

use App\Models\Site;

class SiteController extends Controller
{
    public function site($request, $response, $args){
        return $this->container->view->render($response, 'site.twig');
    }

    public function list($request, $response, $args){
        $role = $this->container->role->getUserRole();
        $user = $this->container->auth->user();
        if (empty($args['site_id'])) {
            return ($role->role_name === 'admin')
                ? $response->withJson(Site::all())
                : $response->withJson(Site::where('owner_id', $user->id)->get());
        }
        return $response->withJson(Site::findorFail($args['id']));
    }

    public function getCreate($request, $response, $args) {
        return $this->container->view->render($response, 'site_create.twig');
    }
    
    //ЗАГЛУШКА
    public function postCreate($request, $response, $args){
        return $response->withJson($request->getParsedBody());
    }
    
    public function edit($request, $response, $args) {
        $site = Site::findorFail($args['id']);
        return $this->container->view->render(
            $response,
            'site/edit.twig',
            array('site' => $site)
        );
    }

    public function update($request, $response, $args) {
        $site = Site::findOrFail($args['id']);
        foreach ($request->getParsedBody() as $param) {
            $site->{$param['name']} = $param['value'];
        }

        try {
            $site->save();
            return $response->withJson(["data" => ["id" => $site->id]]);
        } catch (\Exception $e) {
            return $response->withJson(
                [
                   'error' => ['code' =>$e->getCode(), 'message' =>  $e->getMessage()]
            ]);
        }
    }
    
    public function dropdownSite($request, $response)
    {
        //если не ajax запрос
        if ( !$request->isXhr())
        {
            return false;
        }

        //Авторизуемся для проверки запроса.
        //admin     admin  - владелец системы
        //owner1    owner  - владелец сайта
        //operator1 operator

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

        try {
            //если владелец системы
            if($user->role_id == 2) {
                //если приходит id владельца сайта, выводим все сайты по нему
                if (isset($_GET['owner_id'])) {
                    $sites = Site::where('owner_id', $_GET['owner_id'])->get();
                }
                else {
                    $sites = Site::all();
                }
            }
            //если владелец сайта, выводим его сайты
            if ($user->role_id == 1){
                $sites = Site::where('owner_id', $user->id)->get();
            }
            return json_encode($sites);
        }
        catch (Exception $e){
            $output ="";
            $output['error']['code'] = 404;
            $output['error']['message'] = "ID not found";
            //        $json_data['error']['message'] = $e->getMessage(); //для себя
            return json_encode($output);
        }
    }
}