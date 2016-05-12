<?php
namespace Domain\Auth\Service\AuthService\SignUpValidation;

use Domain\Auth\Parameters\SignUpParameters;
use Domain\Auth\Service\AuthService\Exceptions\ValidationException;

class ArePasswordsMatching implements Validator
{
    public function validate(SignUpParameters $parameters) {
        $isValid = $parameters->getPassword() === $parameters->getRepeat();

        if(! $isValid) {
            throw new ValidationException('Passwords does not match');
        }
    }
}