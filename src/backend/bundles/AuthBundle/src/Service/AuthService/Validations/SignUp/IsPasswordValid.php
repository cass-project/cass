<?php
namespace Auth\Service\AuthService\Validations\SignUp;

use Auth\Service\AuthService\Exceptions\ValidationException;

class IsPasswordValid extends Validator
{

    public function validate()
    {
        if (!$this->arePasswordsMatching()) {
            throw new ValidationException('Passwords does not match');
        }

        if (!$this->isPasswordSecure()) {
            throw new ValidationException('Password must be at least 6 characters with one uppercase letter and digit.');
        }
    }

    private function arePasswordsMatching() : bool
    {
        return $this->credentials['password'] === $this->credentials['passwordAgain'];
    }

    private function isPasswordSecure() : bool
    {
        $pattern = '~((?=.*[a-z])(?=.*\d)(?=.*[A-Z]).{6,})~';
        return preg_match($pattern, $this->credentials['password']) === 1;
    }

}