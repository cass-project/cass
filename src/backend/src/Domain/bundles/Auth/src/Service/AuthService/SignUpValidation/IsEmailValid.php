<?php
namespace Domain\Auth\Service\AuthService\SignUpValidation;

use Domain\Auth\Parameters\SignUpParameters;
use Domain\Auth\Service\AuthService\Exceptions\ValidationException;

class IsEmailValid implements Validator
{
    public function validate(SignUpParameters $parameters) {
        $isValid = filter_var($parameters->getEmail(), FILTER_VALIDATE_EMAIL) !== false;

        if(!$isValid) {
            throw new ValidationException('Invalid email format');
        }
    }
}