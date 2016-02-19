<?php
namespace Auth\Service;

use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Doctrine\ORM\EntityManager;

class AuthService
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEntityManager(){
        return $this->entityManager;
    }

    public function attemptSignIn($login, $password) {
        //$this->entityManager->createQuery("");
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