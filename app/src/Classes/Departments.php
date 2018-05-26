<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 20.11.17
 * Time: 21:58
 */
namespace App\Classes;

use App\Models\Department;

class Departments
{
    public function getDepartments() {
        return Department::all();
    }
}