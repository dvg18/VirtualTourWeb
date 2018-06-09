<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 07.11.17
 * Time: 2:01
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /**
     * @var string
     */
    protected $table = 'UserRole';
    /**
     * @var array
     */
    protected $fillable = [
        'role_name',
        'description',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
    //protected $primaryKey = 'role_id';
}