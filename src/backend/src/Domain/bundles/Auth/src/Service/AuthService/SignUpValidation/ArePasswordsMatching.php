<?php
namespace Domain\Auth\Service\AuthService\SignUpValidation;

use Domain\Auth\Service\AuthService\Exceptions\ValidationException;

class ArePasswordsMatching implements Validator
{
    public function validate(array $request) {
        $isValid = $request['password'] === $request['repeat'];

        if(!$isValid) {
            throw new ValidationException('Passwords does not match');
        }
    }
}