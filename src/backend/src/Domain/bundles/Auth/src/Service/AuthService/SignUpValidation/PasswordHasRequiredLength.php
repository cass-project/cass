<?php
namespace CASS\Domain\Auth\Service\AuthService\SignUpValidation;


use CASS\Domain\Auth\Parameters\SignUpParameters;
use CASS\Domain\Auth\Exception\ValidationException;

class PasswordHasRequiredLength implements Validator
{
    public function validate(SignUpParameters $signUpParameters) {
        $password = $signUpParameters->getPassword();

        $isValid = is_string($password) && (strlen($password) >= 6) || (strlen($password) <= 40);

        if(!$isValid) {
            throw new ValidationException('Password must be at least 6 characters');
        }
    }

}