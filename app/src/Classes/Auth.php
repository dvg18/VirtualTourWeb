<?php
/**
 * Created by PhpStorm.
 * User: reghi
 * Date: 01.11.2017
 * Time: 3:42
 */

namespace App\Classes;

use App\Models\User;

class Auth
{
    public function user(){
        return User::find($_SESSION['user']);
    }

    public function check(){
        return isset($_SESSION['user']);
    }

    public function attempt($login, $password){

        $user = User::where('login', $login)->first();

        if(!$user){
            return false;
        }

        if (password_verify($password, $user->password)){
            $_SESSION['user'] = $user->id;
            return true;
        }

        return false;
    }

    public function logout(){
        unset($_SESSION['user']);
    }
}