<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 07.11.17
 * Time: 1:45
 */

namespace App\Classes;

use App\Models\UserRole;
use App\Models\User;

class Role
{
    /**
     * @return mixed
     */
    public function getUserRole() {
        $user = User::find($_SESSION['user']);

        //return UserRole::find($user->role_id);
        return UserRole::where('id', $user->role_id)->first();
    }

    /**
     * @return UserRole[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getRoles() {
        return UserRole::all();
    }

}