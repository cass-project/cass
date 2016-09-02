<?php
namespace CASS\Domain\Auth\Service\AuthService\SignUpValidation;

use CASS\Domain\Auth\Parameters\SignUpParameters;

interface Validator
{
    public function validate(SignUpParameters $signUpParameters);
}