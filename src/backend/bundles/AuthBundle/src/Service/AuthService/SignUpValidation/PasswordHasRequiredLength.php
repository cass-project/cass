<?php
namespace Auth\Service\AuthService\SignUpValidation;


use Auth\Service\AuthService\Exceptions\ValidationException;

class PasswordHasRequiredLength implements Validator
{
    public function validate(array $request) {
        $isValid = preg_match('~((?=.*[a-z])(?=.*\d)(?=.*[A-Z]).{6,})~', $request['password']) == 0;

        if(!$isValid) {
            throw new ValidationException('Password must be at least 6 characters with one uppercase letter and digit.');
        }
    }

}