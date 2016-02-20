<?php
namespace Auth\Service;

use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Data\Entity\Account;
use Doctrine\ORM\EntityManager;

class AuthService
{
    private $entityManager;
    private $account_token;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->account_token = isset($_COOKIE['account_token']) ? $_COOKIE['account_token'] : false;
    }

    public function attemptSignIn($data)
    {
        if(!$this->account_token && (empty($data['login']) || empty($data['password']))) {
            throw new InvalidCredentialsException('Email or phone and password are required');
        }

        if($this->account_token && empty($data['login'])){
            $data['login'] = $this->account_token;
        }
        /** @var Account $account */
        $account  = $this->entityManager
                        ->getRepository(Account::class)
                        ->createQueryBuilder('account')
                            ->where('account.email = :login OR account.phone = :login OR account.token = :login')
                                ->setParameter("login", $data['login'])
                        ->getQuery()->getSingleResult();

        if(!$this->validateAccountToken($account)) {
            if($this->validateAccountPassword($account,$data['password'])) {
                $account
                    ->setToken()
                    ->setTokenExpired(strtotime("+7 days"));

                $this->entityManager->persist($account);
                $this->entityManager->flush();
            } else {
                throw new InvalidCredentialsException(sprintf('Fail to sign-in as `%s`', $data['login']));
            }
        }
        setcookie('account_token', $account->getToken(), $account->getTokenExpired());
    }

    private function validateAccountToken(Account $account) : bool{
        return $this->account_token && $this->account_token == $account->getToken() && time() < $account->getTokenExpired();
    }

    private function validateAccountPassword(Account $account, $password) : bool{
        return password_verify($password, $account->getPassword());
    }

    public function signUp($data)
    {
        if(empty($data['email']) && empty($data['phone']) || empty($data['password'])) {
            throw new InvalidCredentialsException('Email or phone and password are required');
        }

        if(isset($data['email']) && false === filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidCredentialsException("Invalid email format");
        }

        if(strcmp($data['password'], $data['passwordAgain'])){
            throw new InvalidCredentialsException("Passwords does not match");
        }

        if(preg_match("~((?=.*[a-z])(?=.*\d)(?=.*[A-Z]).{6,})~", $data['password'])==0){
            throw new InvalidCredentialsException("Passwords must be at least 6 characters contain one uppercase letter and digit.");
        }

        $accountRepository = $this->entityManager->getRepository(Account::class);

        if(isset($data['email']) && $accountRepository->findOneBy(["email"=>$data['email']])){
            throw new InvalidCredentialsException(sprintf('Account with email `%s` already exist.', $data['email']));
        }

        if(isset($data['phone']) && $accountRepository->findOneBy(["phone"=>$data['phone']])){
            throw new InvalidCredentialsException(sprintf('Account with phone `%s` already exist.', $data['phone']));
        }

        $account = new Account();
        $account
            ->setEmail(isset($data['email'])?$data['email']:null)
            ->setPhone(isset($data['phone'])?$data['phone']:null)
            ->setPassword(password_hash($data['password'], PASSWORD_DEFAULT))
            ->setToken()
        ;

        $this->entityManager->persist($account);
        $this->entityManager->flush();
    }

    public function logOut()
    {
        return true;
    }
}