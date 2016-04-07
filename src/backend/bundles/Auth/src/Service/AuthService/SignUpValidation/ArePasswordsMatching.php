<?php
namespace Auth\Service\AuthService\SignUpValidation;

use Auth\Service\AuthService\Exceptions\ValidationException;

class ArePasswordsMatching implements Validator
{
    public function validate(array $request) {
        $isValid = $request['password'] === $request['repeat'];

        if(!$isValid) {
            throw new ValidationException('Passwords does not match');
        }
    }
}