<?php
namespace CASS\Domain\Bundles\Auth\Service\AuthService\SignUpValidation;

use CASS\Domain\Bundles\Auth\Parameters\SignUpParameters;

interface Validator
{
    public function validate(SignUpParameters $signUpParameters);
}