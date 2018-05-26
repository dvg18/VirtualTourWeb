<?php
/**
 * Created by PhpStorm.
 * User: reghi
 * Date: 30.10.2017
 * Time: 11:55
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $table = 'User';

    protected $fillable = [
        'login',
        'password',
        'last_name',
        'first_name',
        'info',
        'is_blocked',
        'department_id',
        'role_id',
        'site_id',
    ];

    public $timestamps = false;
}