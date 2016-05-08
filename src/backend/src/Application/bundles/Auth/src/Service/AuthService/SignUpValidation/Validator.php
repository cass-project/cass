<?php
namespace Application\Auth\Service\AuthService\SignUpValidation;

interface Validator
{
    public function validate(array $request);
}