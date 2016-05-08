<?php
namespace Application\Auth\Service\AuthService\SignUpValidation;

use Application\Auth\Service\AuthService\Exceptions\ValidationException;

class IsEmailValid implements Validator
{
    public function validate(array $request) {
        $isValid = filter_var($request['email'], FILTER_VALIDATE_EMAIL) !== false;

        if(!$isValid) {
            throw new ValidationException('Invalid email format');
        }
    }
}