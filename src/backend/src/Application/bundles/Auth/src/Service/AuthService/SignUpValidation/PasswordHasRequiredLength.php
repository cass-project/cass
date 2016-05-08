<?php
namespace Application\Auth\Service\AuthService\SignUpValidation;


use Application\Auth\Service\AuthService\Exceptions\ValidationException;

class PasswordHasRequiredLength implements Validator
{
    public function validate(array $request) {
        $isValid = (strlen($request['password']) >= 6) || (strlen($request['password']) <= 40);

        if(!$isValid) {
            throw new ValidationException('Password must be at least 6 characters');
        }
    }

}