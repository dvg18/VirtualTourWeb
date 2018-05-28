<?php
/**
 * Created by PhpStorm.
 * User: reghi
 * Date: 30.10.2017
 * Time: 11:55
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCollection extends Model
{
    protected $table = 'UserCollection';

    protected $fillable = [
        'name',
        'password',
        'image_count',
        'isPublic',
        'user_id',
    ];

    //public $timestamps = false;
}