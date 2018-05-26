<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 07.11.17
 * Time: 2:01
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model {

    protected $table = 'UserRole';

    protected $fillable = [
        'role_id',
        'role_name',
        'description',
    ];

    public $timestamps = false;
    protected $primaryKey = 'role_id';
}