<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 07.11.17
 * Time: 1:45
 */

namespace App\Classes;

use App\Models\UserCollection;
use App\Models\User;

class Collections
{
    public function getUserColletions()
    {
        $user = User::find($_SESSION['user']);
        return UserCollection::where('user_id', $user->id)->get();
    }

    public function getCollections()
    {
        return UserCollection::all();
    }

     public function getPublic(){
         $collections = UserCollection::where("isPublic", 1)->get();
         return $collections;
     }
    public static function getFiles($id, $path)
    {
        $collection = UserCollection::findOrFail($id);
        $user = User::findOrFail($collection->user_id);
        $file_path = $path . $user->login . '/' . $collection->id . '/';
        $files = scandir($file_path);
        return $files;
    }
}