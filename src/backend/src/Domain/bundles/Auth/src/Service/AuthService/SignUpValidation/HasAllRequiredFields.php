<?php
namespace Domain\Auth\Service\AuthService\SignUpValidation;

use Domain\Auth\Parameters\SignUpParameters;
use Domain\Auth\Exception\MissingRequiredFieldException;

class HasAllRequiredFields implements Validator
{
    public function validate(SignUpParameters $signUpParameters)
    {
        $hasEmail = strlen($signUpParameters->getEmail()) > 0;
        $hasPassword = !empty($signUpParameters->getPassword());

        $isValid = $hasEmail && $hasPassword;

        if(! $isValid) {
            throw new MissingRequiredFieldException('Email and password are required');
        }
    }
}