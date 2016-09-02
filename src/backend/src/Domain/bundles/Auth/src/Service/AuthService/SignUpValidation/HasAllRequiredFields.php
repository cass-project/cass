<?php
namespace CASS\Domain\Bundles\Auth\Service\AuthService\SignUpValidation;

use CASS\Domain\Bundles\Auth\Parameters\SignUpParameters;
use CASS\Domain\Bundles\Auth\Exception\MissingRequiredFieldException;

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