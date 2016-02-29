<?php
namespace Auth\Service\AuthService\SignUpValidation;

use Auth\Service\AuthService\Exceptions\ValidationException;
use Psr\Http\Message\ServerRequestInterface;

class IsEmailValid implements Validator
{
    public function validate(ServerRequestInterface $request) {
        $isValid = !(isset($request['email']) && false === filter_var($request['email'], FILTER_VALIDATE_EMAIL));

        if(!($isValid)) {
            throw new ValidationException('Invalid email format');
        }
    }
}