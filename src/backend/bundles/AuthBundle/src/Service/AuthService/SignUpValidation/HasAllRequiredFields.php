<?php
namespace Auth\Service\AuthService\SignUpValidation;

use Auth\Service\AuthService\Exceptions\MissingReqiuredFieldException;
use Psr\Http\Message\ServerRequestInterface;

class HasAllRequiredFields implements Validator
{
    public function validate(ServerRequestInterface $request)
    {
        $isValid = (empty($request['email']) && empty($request['phone']) || empty($request['password']));

        if(!($isValid)) {
            throw new MissingReqiuredFieldException('Email or phone and password are required');
        }
    }
}