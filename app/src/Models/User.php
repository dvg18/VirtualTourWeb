<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    /**
     * @var string
     */
    protected $table = 'User';
    /**
     * @var array
     */
    protected $fillable = [
        'login',
        'password',
        'last_name',
        'first_name',
        'info',
        'role_id',
    ];
}