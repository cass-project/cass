<?php
namespace CASS\Domain\Bundles\Auth\Service\AuthService\SignUpValidation;

use CASS\Domain\Bundles\Auth\Parameters\SignUpParameters;
use CASS\Domain\Bundles\Auth\Exception\ValidationException;

class IsEmailValid implements Validator
{
    public function validate(SignUpParameters $parameters) {
        $isValid = filter_var($parameters->getEmail(), FILTER_VALIDATE_EMAIL) !== false;

        if(!$isValid) {
            throw new ValidationException('Invalid email format');
        }
    }
}