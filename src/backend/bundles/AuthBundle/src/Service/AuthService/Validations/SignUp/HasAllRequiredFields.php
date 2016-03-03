<?php
namespace Auth\Service\AuthService\Validations\SignUp;

use Auth\Service\AuthService\Exceptions\MissingReqiuredFieldException;

class HasAllRequiredFields extends Validator
{

    public function validate()
    {
        if (!$this->hasLogin() || !$this->hasPassword()) {
            throw new MissingReqiuredFieldException('Email or phone and password are required');
        }
    }

    private function hasLogin() : bool
    {
        return $this->hasEmail() || $this->hasPhone();
    }

    private function hasEmail() : bool
    {
        return !empty($this->credentials['email']);
    }

    private function hasPhone() : bool
    {
        return !empty($this->credentials['phone']);
    }

    private function hasPassword() : bool
    {
        return !empty($this->credentials['password']) && !empty($this->credentials['passwordAgain']);
    }

}
