<?php
namespace Application\Auth\Service\AuthService\SignUpValidation;

use Application\Auth\Service\AuthService\Exceptions\ValidationException;

class ArePasswordsMatching implements Validator
{
    public function validate(array $request) {
        $isValid = $request['password'] === $request['repeat'];

        if(!$isValid) {
            throw new ValidationException('Passwords does not match');
        }
    }
}