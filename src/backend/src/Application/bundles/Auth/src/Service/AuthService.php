<?php
namespace Application\Auth\Service;

use Application\Account\Service\AccountService;
use Application\Auth\Middleware\AuthStrategy\SessionStrategy;
use Application\Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Application\Auth\Service\AuthService\OAuth2\RegistrationRequest;
use Application\Auth\Service\AuthService\SignUpValidation\ArePasswordsMatching;
use Application\Auth\Service\AuthService\SignUpValidation\HasAllRequiredFields;
use Application\Auth\Service\AuthService\SignUpValidation\HasSameAccount;
use Application\Auth\Service\AuthService\SignUpValidation\IsEmailValid;
use Application\Auth\Service\AuthService\SignUpValidation\PasswordHasRequiredLength;
use Application\Auth\Service\AuthService\SignUpValidation\Validator as SignUpValidator;
use Application\Account\Entity\Account;
use Application\Frontline\Service\FrontlineService;
use Application\Profile\Entity\Profile;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthService
{
    const FRONTLINE_KEY = 'auth';

    /** @var AccountService */
    private $accountService;

    /** @var FrontlineService */
    private $frontlineService;

    /** @var array */
    private $oauth2Config;

    public function __construct(AccountService $accountService, FrontlineService $frontlineService, array $oauth2Config)
    {
        $this->accountService = $accountService;
        $this->frontlineService = $frontlineService;
        $this->oauth2Config = $oauth2Config;
    }

    public function auth(Account $account): Account
    {
        $_SESSION[SessionStrategy::SESSION_API_KEY] = $account->getAPIKey();

        return $account;
    }

    public function signUp(Request $request): Account
    {
        $request = json_decode($request->getBody(), true);

        $email = $request['email'] ?? null;
        $password = $request['password'] ?? null;

        array_map(function(SignUpValidator $validator) use ($request) {
            $validator->validate($request);
        }, [
            new HasAllRequiredFields(),
            new IsEmailValid(),
            new ArePasswordsMatching(),
            new PasswordHasRequiredLength(),
            new HasSameAccount($this->accountService)
        ]);

        return $this->accountService->createAccount($email, password_hash($password, PASSWORD_DEFAULT));
    }

    public function signIn(Request $request) : Account
    {
        list($email, $password) = $this->unpackCredentials($request);

        $account = $this->accountService->findByEmail($email);

        if(!$this->verifyPassword($account, $password)) {
            throw new InvalidCredentialsException(sprintf('Fail to sign-in as `%s`', $email));
        }

        return $this->auth($account);
    }

    public function signInOauth2(RegistrationRequest $registrationRequest)
    {
        if(!$this->accountService->hasAccountWithEmail($registrationRequest->getEmail())) {
            $this->accountService->createOAuth2Account(
                $registrationRequest->getEmail(),
                $registrationRequest->getProvider(),
                $registrationRequest->getProviderAccountId()
            );
        }

        $oauth2Account = $this->accountService->findOAuthAccount($registrationRequest->getProvider(), $registrationRequest->getProviderAccountId());

        return $this->auth($oauth2Account->getAccount());
    }

    public function signOut()
    {
        $_SESSION[SessionStrategy::SESSION_API_KEY] = null;
    }

    public function getOAuth2Config($provider): array
    {
        $config = $this->oauth2Config[$provider] ?? null;

        if(!$config) {
            throw new \Exception(sprintf('OAuth2 configuration for provider `%s` not found', $provider));
        }

        return $config;
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
