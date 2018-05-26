<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 20.11.17
 * Time: 22:00
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {
    protected $table = 'Department';

    protected $fillable = [
        'department_id',
        'department_name',
        'description',
        'site_id'
    ];

    public $timestamps = false;
    protected $primaryKey = 'department_id';
}