<?php
namespace Auth\Service;

use Auth\Service\AuthService\Exceptions\DuplicateAccountException;
use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Auth\Service\AuthService\SignUpValidation\ArePasswordsMatching;
use Auth\Service\AuthService\SignUpValidation\HasAllRequiredFields;
use Auth\Service\AuthService\SignUpValidation\HasSameAccount;
use Auth\Service\AuthService\SignUpValidation\IsEmailValid;
use Auth\Service\AuthService\SignUpValidation\PasswordHasRequiredLength;
use Auth\Service\AuthService\SignUpValidation\Validator;
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
        $this->entityManager     = $entityManager;
        $this->accountRepository = $entityManager->getRepository(Account::class);
    }

    public function attemptSignIn(Request $request) : Account
    {
        $credentials = json_decode($request->getBody(), true);

        if (isset($credentials['login']) || isset($credentials['password'])) {
            $this->signOut();

            if (!isset($credentials['login'], $credentials['password'])) {
                throw new InvalidCredentialsException('Email or phone and password are required');
            }
        }

        if (isset($_SESSION['account'])) {
            $account = unserialize($_SESSION['account']); /** @var Account $account */
        } else {
            $account = $this->accountRepository
                ->findByLoginOrToken($credentials['login'] ?? $this->getToken($request));
        }

        if (!$this->verifyToken($account, $request) && !$this->verifyPassword($account, $request)) {
            throw new InvalidCredentialsException(sprintf('Fail to sign-in as `%s`', $credentials['login']));
        }

        $this->signIn($account);

        return $account;
    }

    public function signUp(Request $request, bool $signInAfter=true) : Account
    {
        $request = json_decode($request->getBody(), true);

        array_map(function(Validator $validator) use ($request) {
            $validator->validate($request);
        }, [
            new HasAllRequiredFields(),
            new IsEmailValid(),
            new ArePasswordsMatching(),
            new PasswordHasRequiredLength(),
            new HasSameAccount($this->accountRepository)
        ]);

        $account = (new Account())
            ->setEmail($request['email'] ?? null)
            ->setPhone($request['phone'] ?? null)
            ->setPassword(password_hash($request['password'], PASSWORD_DEFAULT))
        ;

        if ($signInAfter) {
            $this->signIn($account);
        } else {
            $this->entityManager->persist($account);
            $this->entityManager->flush();
        }

        return $account;
    }

    public function signIn(Account $account)
    {
        if (!$account->getToken() || $account->getTokenExpired() < time()) {
            $account->setToken()
                ->setTokenExpired(strtotime('+30 minutes'))
            ;
            $this->entityManager->persist($account);
            $this->entityManager->flush();
        }

        $_SESSION['account'] = serialize($account);
    }

    public function signOut()
    {
        unset($_SESSION['account']);
    }

    private function getToken(Request $request)
    {
        return $request->hasHeader('Account-Token') ? $request->getHeader('Account-Token')[0] : null;
    }

    private function verifyToken(Account $account, Request $request) : bool
    {
        return $account->getToken() &&
               $account->getToken() === $this->getToken($request);
    }

    private function verifyPassword(Account $account, Request $request) : bool
    {
        $credentials = json_decode($request->getBody(), true);
        return isset($credentials['password']) &&
               password_verify($credentials['password'], $account->getPassword());
    }

}
