<?php
namespace Domain\Auth\Service\AuthService\SignUpValidation;

use Domain\Auth\Parameters\SignUpParameters;

interface Validator
{
    public function validate(SignUpParameters $signUpParameters);
}