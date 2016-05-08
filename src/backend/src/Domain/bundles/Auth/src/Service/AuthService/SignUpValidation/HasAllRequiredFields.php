<?php
namespace Domain\Auth\Service\AuthService\SignUpValidation;

use Domain\Auth\Service\AuthService\Exceptions\MissingRequiredFieldException;

class HasAllRequiredFields implements Validator
{
    public function validate(array $request)
    {
        $hasEmailOrPhone = !(empty($request['email']) && empty($request['phone']));
        $hasPassword = !empty($request['password']);

        $isValid = $hasEmailOrPhone && $hasPassword;

        if(!$isValid) {
            throw new MissingRequiredFieldException('Email or phone and password are required');
        }
    }
}