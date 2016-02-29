<?php
namespace Auth\Service\AuthService\SignUpValidation;

use Psr\Http\Message\ServerRequestInterface;

interface Validator
{
    public function validate(ServerRequestInterface $request);
}