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
    /**
     * @var string
     */
    protected $table = 'UserCollection';
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'password',
        'image_count',
        '',
        'user_id',
    ];

    //public $timestamps = false;
}