<?php
namespace Auth\Service;

use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Auth\Service\AuthService\SignUpValidation\ArePasswordsMatching;
use Auth\Service\AuthService\SignUpValidation\HasAllRequiredFields;
use Auth\Service\AuthService\SignUpValidation\HasSameAccount;
use Auth\Service\AuthService\SignUpValidation\IsEmailValid;
use Auth\Service\AuthService\SignUpValidation\PasswordHasRequiredLength;
use Auth\Service\AuthService\SignUpValidation\Validator;
use Data\Entity\Account;
use Data\Repository\AccountRepository;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthService
{
    /** @var AccountRepository */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function signUp(Request $request) : Account
    {
        $request = json_decode($request->getBody(), true);

        $email = $request['email'] ?? null;
        $password = $request['password'] ?? null;

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
            ->setEmail($email)
            ->setPassword(password_hash($password, PASSWORD_DEFAULT))
        ;

        $this->accountRepository->saveAccount($account);

        return $account;
    }

    public function signIn(Request $request) : Account
    {
        list($email, $password) = $this->unpackCredentials($request);

        $account = $this->accountRepository->findByEmail($email);

        if(!$this->verifyPassword($account, $password)) {
            throw new InvalidCredentialsException(sprintf('Fail to sign-in as `%s`', $email));
        }

        return $account;
    }

    public function signOut()
    {
        unset($_COOKIE['api_key']);
    }

    private function verifyPassword(Account $account, string $password): bool
    {
        return password_verify($password, $account->getPassword());
    }

    private function unpackCredentials(Request $request): array
    {
        $credentials = json_decode($request->getBody(), true);
        $email = $credentials['email'] ?? null;
        $password = $credentials['password'] ?? null;

        if ($email === null || $password === null) {
            throw new InvalidCredentialsException('Email and password are required');
        }

        return array($email, $password);
    }
}
