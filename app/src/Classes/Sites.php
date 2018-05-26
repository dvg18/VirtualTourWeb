<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 20.11.17
 * Time: 22:04
 */
namespace App\Classes;

use App\Models\Site;

class Sites
{
    public function getSites() {
        return Site::all();
    }
}