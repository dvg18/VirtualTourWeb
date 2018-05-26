<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 07.12.17
 * Time: 1:49
 */

namespace App\Classes\Validation;

use Respect\Validation\Exceptions\ValidationException;

class LoginAvailableException extends ValidationException
{
    public static $defaultTemplates = [
      self::MODE_DEFAULT => [
          self::STANDARD => 'Логин уже используется.'
      ]
    ];
}