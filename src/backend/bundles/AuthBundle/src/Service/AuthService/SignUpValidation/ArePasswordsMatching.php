<?php
namespace Auth\Service\AuthService\SignUpValidation;

use Auth\Service\AuthService\Exceptions\ValidationException;
use Psr\Http\Message\ServerRequestInterface;

class ArePasswordsMatching implements Validator
{
    public function validate(ServerRequestInterface $request) {
        $isValid = empty($request['passwordAgain']) || strcmp($request['password'], $request['passwordAgain']);

        if(!($isValid)) {
            throw new ValidationException('Passwords does not match');
        }
    }
}