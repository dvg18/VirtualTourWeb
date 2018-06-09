<?php
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
        'role_id',
    ];
}