<?php
namespace Auth\Service;

use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Data\Entity\Account;
use Data\Repository\AccountRepository;
use Doctrine\ORM\EntityManager;

class AuthService
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
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

        $em = $this->entityManager;
        $accountRepository = $em->getRepository(Account::class);

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

        $em->persist($account);
        $em->flush();
    }

    public function logOut() {
        return true;
    }
}