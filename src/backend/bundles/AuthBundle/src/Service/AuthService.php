<?php
namespace Auth\Service;

use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;

class AuthService
{
    public function attemptSignIn($login, $password) {
        $result = ($login === 'admin' && $password === '1234');

        if($result) {
            return true;
        }else{
            throw new InvalidCredentialsException(sprintf('Fail to sign-in with login `%s`', $login));
        }
    }

    public function logOut() {
        return true;
    }
}