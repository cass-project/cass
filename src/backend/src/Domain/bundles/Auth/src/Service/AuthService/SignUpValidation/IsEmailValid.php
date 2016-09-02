<?php
namespace CASS\Domain\Auth\Service\AuthService\SignUpValidation;

use CASS\Domain\Auth\Parameters\SignUpParameters;
use CASS\Domain\Auth\Exception\ValidationException;

class IsEmailValid implements Validator
{
    public function validate(SignUpParameters $parameters) {
        $isValid = filter_var($parameters->getEmail(), FILTER_VALIDATE_EMAIL) !== false;

        if(!$isValid) {
            throw new ValidationException('Invalid email format');
        }
    }
}