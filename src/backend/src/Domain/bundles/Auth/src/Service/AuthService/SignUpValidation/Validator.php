<?php
namespace Domain\Auth\Service\AuthService\SignUpValidation;

interface Validator
{
    public function validate(array $request);
}