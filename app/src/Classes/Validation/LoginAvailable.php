<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 07.12.17
 * Time: 1:41
 */

namespace App\Classes\Validation;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

class LoginAvailable extends AbstractRule
{
    public function validate($input)
    {

        return User::where('login', $input)->count() === 0;
    }
}