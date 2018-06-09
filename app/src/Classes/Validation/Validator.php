<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 06.12.17
 * Time: 3:54
 */

namespace App\Classes\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    /**
     * @var
     */
    protected $errors;

    /**
     * @param $request
     * @param array $rules
     * @return $this
     */
    public function validate($request, array $rules){

        foreach ($rules as $field => $rule)
        {
            try{
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            }
            catch (NestedValidationException $e){
                $this->errors[$field] = $e->getMessages();
            }

        }
        $_SESSION['errors'] = $this->errors;
        return $this;
    }

    /**
     * @param $request
     * @return bool
     */
    public function failed($request){

        return !empty($this->errors);
    }

}