<?php
namespace Auth\Service\AuthService\SignUpValidation;

interface Validator
{
    public function validate(array $request);
}