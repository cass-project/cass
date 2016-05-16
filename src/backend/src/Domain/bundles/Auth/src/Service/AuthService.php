<?php
namespace Domain\Auth\Service;

use Domain\Account\Service\AccountService;
use Domain\Auth\Middleware\AuthStrategy\SessionStrategy;
use Domain\Auth\Parameters\SignInParameters;
use Domain\Auth\Parameters\SignUpParameters;
use Domain\Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Domain\Auth\Service\AuthService\OAuth2\RegistrationRequest;
use Domain\Auth\Service\AuthService\SignUpValidation\ArePasswordsMatching;
use Domain\Auth\Service\AuthService\SignUpValidation\HasAllRequiredFields;
use Domain\Auth\Service\AuthService\SignUpValidation\HasSameAccount;
use Domain\Auth\Service\AuthService\SignUpValidation\IsEmailValid;
use Domain\Auth\Service\AuthService\SignUpValidation\PasswordHasRequiredLength;
use Domain\Auth\Service\AuthService\SignUpValidation\Validator as SignUpValidator;
use Domain\Account\Entity\Account;
class AuthService
{
    const FRONTLINE_KEY = 'auth';

    /** @var AccountService */
    private $accountService;
    
    /** @var PasswordVerifyService */
    private $passwordVerifyService;

    /** @var array */
    private $oauth2Config;

    public function __construct(
        AccountService $accountService,
        PasswordVerifyService $passwordVerifyService,
        array $oauth2Config)
    {
        $this->accountService = $accountService;
        $this->passwordVerifyService = $passwordVerifyService;
        $this->oauth2Config = $oauth2Config;
    }

    public function auth(Account $account): Account
    {
        $_SESSION[SessionStrategy::SESSION_API_KEY] = $account->getAPIKey();

        return $account;
    }

    public function signUp(SignUpParameters $signUpParameters): Account
    {
        $email = $signUpParameters->getEmail();
        $password = $signUpParameters->getPassword();

        array_map(function(SignUpValidator $validator) use ($signUpParameters) {
            $validator->validate($signUpParameters);
        }, [
            new HasAllRequiredFields(),
            new IsEmailValid(),
            new ArePasswordsMatching(),
            new PasswordHasRequiredLength(),
            new HasSameAccount($this->accountService)
        ]);

        return $this->accountService->createAccount($email, $password);
    }

    public function signIn(SignInParameters $parameters) : Account
    {
        $email = $parameters->getEmail();
        $password = $parameters->getPassword();

        $account = $this->accountService->findByEmail($email);

        if(! $this->verifyPassword($account, $password)) {
            throw new InvalidCredentialsException(sprintf('Fail to sign-in as `%s`', $email));
        }

        return $this->auth($account);
    }

    public function signInOauth2(RegistrationRequest $registrationRequest)
    {
        if(!$this->accountService->hasAccountWithEmail($registrationRequest->getEmail())) {
            $this->accountService->createOAuth2Account($registrationRequest);
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

    public function verifyPassword(Account $account, string $password): bool
    {
        return $this->passwordVerifyService->verifyPassword($account, $password);
    }
}
