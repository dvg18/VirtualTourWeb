<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 20.11.17
 * Time: 22:00
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model {
    protected $table = 'Site';

    protected $fillable = [
        'site_name',
        'widget_settings',
        'owner_id',
    ];

    public $timestamps = false;
}