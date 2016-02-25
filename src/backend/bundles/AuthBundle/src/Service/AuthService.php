<?php
namespace Auth\Service;

use Auth\Service\AuthService\Exceptions\DuplicateAccountException;
use Auth\Service\AuthService\Exceptions\ValidationException;
use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Auth\Service\AuthService\Exceptions\MissingReqiuredFieldException;
use Data\Entity\Account;
use Data\Repository\AccountRepository;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthService
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->accountRepository = $entityManager->getRepository(Account::class);
    }

    public function signIn(Request $request) : Account
    {
        $request =  json_decode($request->getBody(), true);

        if(isset($request['login']) || isset($request['password'])) {
            $this->removeToken();

            if(!isset($request['login'], $request['password'])) {
                throw new InvalidCredentialsException('Email or phone and password are required');
            }
        }

        /** @var Account $account */
        $account = $this->accountRepository->findByLoginOrToken($request['login'] ?? $this->getToken());

        if(!$this->validateAccountToken($account)) {
            if(isset($request['password']) && $this->validateAccountPassword($account, $request['password'])) {
                $account->setToken();
            } else {
                throw new InvalidCredentialsException(sprintf('Fail to sign-in as `%s`', $request['login']));
            }
        }

        $account->setTokenExpired(strtotime("+1 hour"));
        $this->setToken($account->getToken());
        $this->entityManager->persist($account);
        $this->entityManager->flush();

        return $account;
    }

    public function signUp(Request $request, bool $signInAfter = true) : Account
    {
        $request =  json_decode($request->getBody(), true);

        if(empty($request['email']) && empty($request['phone']) || empty($request['password'])) {
            throw new MissingReqiuredFieldException('Email or phone and password are required');
        }

        if(isset($request['email']) && false === filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException("Invalid email format");
        }

        if(empty($request['passwordAgain']) || strcmp($request['password'], $request['passwordAgain'])) {
            throw new ValidationException("Passwords does not match");
        }

        if(preg_match("~((?=.*[a-z])(?=.*\d)(?=.*[A-Z]).{6,})~", $request['password'])==0) {
            throw new ValidationException("Passwords must be at least 6 characters contain one uppercase letter and digit.");
        }

        if($this->accountRepository->isAccountExist($request['email'] ?? $request['phone'])) {
            throw new DuplicateAccountException(sprintf('%s already in use.', $request['email'] ?? $request['phone']));
        }

        $account = (new Account())
            ->setEmail($request['email'] ?? null)
            ->setPhone($request['phone'] ?? null)
            ->setPassword(password_hash($request['password'], PASSWORD_DEFAULT))
            ->setToken()
            ->setTokenExpired(strtotime("+1 hour"));
        ;

        $this->entityManager->persist($account);
        $this->entityManager->flush();

        if($signInAfter) {
            $this->setToken($account->getToken());
        }
        return $account;
    }

    public function signOut()
    {
        $this->removeToken();
    }

    private function setToken($token)
    {
        $_SESSION['account_token'] = $token;
    }

    private function getToken()
    {
        return $_SESSION['account_token'] ?? null;
    }

    private function removeToken()
    {
        unset($_SESSION['account_token']);
    }

    private function validateAccountToken(Account $account) : bool
    {
        return $this->getToken() && $this->getToken() == $account->getToken() && time() < $account->getTokenExpired();
    }

    private function validateAccountPassword(Account $account, $password) : bool
    {
        return password_verify($password, $account->getPassword());
    }

}