<?php
namespace Auth\Service\AuthService\Validations\SignUp;

use Auth\Service\AuthService\Exceptions\ValidationException;

class IsEmailValid extends Validator
{

    public function validate()
    {
        if ($this->hasEmail() && !$this->isEmail()) {
            throw new ValidationException('Invalid email format');
        }
    }

    private function hasEmail() : bool
    {
        return !empty($this->credentials['email']);
    }

    private function isEmail() : bool
    {
        return filter_var($this->credentials['email'], FILTER_VALIDATE_EMAIL);
    }

}