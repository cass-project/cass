<?php
namespace Auth\Service;

use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Data\Entity\Account;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;

class AuthService
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function attemptSignIn($data) {
        $required = ["login","password"];
        $data = array_intersect_key($data,array_flip($required));
        if(count($required)>count($data)) {
            throw new InvalidCredentialsException('Email or phone and password are required');
        }

        try{
            $account  = $this->entityManager
                        ->getRepository(Account::class)
                        ->createQueryBuilder('account')
                        ->where('account.email = :login OR account.phone = :login')
                        ->setParameter("login", $data['login'])
                        ->getQuery()
                        ->getSingleResult();
        }catch(NoResultException $e){
            throw new InvalidCredentialsException(sprintf('Fail to sign-in with login `%s`', $data['login']));
        }

        if(!password_verify($data['password'], $account->getPassword())){
            throw new InvalidCredentialsException(sprintf('Fail to sign-in with login `%s`', $data['login']));
        }
    }

    public function signUp($data) {
        extract($data);

        if(empty($email) && empty($phone) || empty($password)) {
            throw new InvalidCredentialsException('Email or phone and password are required');
        }

        if(isset($email) && false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidCredentialsException("Invalid email format");
        }

        if(strcmp($password, $passwordAgain)){
            throw new InvalidCredentialsException("Passwords does not match");
        }

        if(preg_match("~((?=.*[a-z])(?=.*\d)(?=.*[A-Z]).{6,})~", $password)==0){
            throw new InvalidCredentialsException("Passwords must be at least 6 characters contain one uppercase letter and digit.");
        }

        $accountRepository = $this->entityManager->getRepository(Account::class);

        if(isset($email) && $accountRepository->findOneBy(["email"=>$email])){
            throw new InvalidCredentialsException(sprintf('Account with email `%s` already exist.', $email));
        }

        if(isset($phone) && $accountRepository->findOneBy(["email"=>$phone])){
            throw new InvalidCredentialsException(sprintf('Account with phone `%s` already exist.', $phone));
        }


        $account = new Account();
        $account
            ->setEmail(isset($email)?$email:null)
            ->setPhone(isset($phone)?$phone:null)
            ->setPassword(password_hash($password, PASSWORD_DEFAULT))
        ;

        $this->entityManager->persist($account);
        $this->entityManager->flush();
    }

    public function logOut() {
        return true;
    }
}