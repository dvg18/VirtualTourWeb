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
/*
        $uploads_dir = 'uploads/';

        $uploadname = $_FILES["image"]["name"];
        $uploadtitle = $_FILES["title"]["title"];


        move_uploaded_file($_FILES['image']['tmp_name'], $uploads_dir . $uploadname);
        file_put_contents($uploads_dir . 'juhl.txt', print_r($uploadtitle, true));


        // Изменим структуру $_FILES
        foreach ($_FILES['upload'] as $key => $value) {
            foreach ($value as $k => $v) {
                $_FILES['upload'][$k][$key] = $v;
            }

            // Удалим старые ключи
            unset($_FILES['upload'][$key]);
        }

// Загружаем все картинки по порядку
        foreach ($_FILES['upload'] as $k => $v) {

            // Загружаем по одному файлу
            $_FILES['upload'][$k]['tmp_name'];
            $_FILES['upload'][$k]['error'];
        }
*/
echo '123';
        if($_FILES)
        {
            foreach ($_FILES["uploads"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["uploads"]["tmp_name"][$key];
                    $name = $_FILES["uploads"]["name"][$key];
                    move_uploaded_file($tmp_name, "$name");
                }
            }
        }

        /*  //$this->logger->info("Home page action dispatched");
          if (!$this->auth->check())
              return $response->withRedirect($this->router->pathFor('auth.signin'));

          $role = Role::getUserRole()->role_name;

          switch ($role) {
              case 'admin' :
                  return $response->withRedirect($this->router->pathFor('chat'));
              case 'operator' :
                  return $response->withRedirect($this->router->pathFor('auth.operator'));
              case 'owner' :
                  return $response->withRedirect($this->router->pathFor('chat'));
              default :
                  return $response->withRedirect($this->router->pathFor('auth.signout')); //нужно направить на какую-нибудь страницу с ошибкой
          }*/
    }
}
