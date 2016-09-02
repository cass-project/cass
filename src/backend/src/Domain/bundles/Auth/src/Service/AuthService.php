<?php
namespace CASS\Domain\Auth\Service;

use CASS\Domain\Account\Service\AccountService;
use CASS\Domain\Auth\Middleware\AuthStrategy\SessionStrategy;
use CASS\Domain\Auth\Parameters\SignInParameters;
use CASS\Domain\Auth\Parameters\SignUpParameters;
use CASS\Domain\Auth\Exception\InvalidCredentialsException;
use CASS\Domain\Auth\Service\AuthService\OAuth2\RegistrationRequest;
use CASS\Domain\Auth\Service\AuthService\SignUpValidation\HasAllRequiredFields;
use CASS\Domain\Auth\Service\AuthService\SignUpValidation\HasSameAccount;
use CASS\Domain\Auth\Service\AuthService\SignUpValidation\IsEmailValid;
use CASS\Domain\Auth\Service\AuthService\SignUpValidation\PasswordHasRequiredLength;
use CASS\Domain\Auth\Service\AuthService\SignUpValidation\Validator as SignUpValidator;
use CASS\Domain\Account\Entity\Account;

class AuthService
{
    const FRONTLINE_KEY = 'auth';

    /** @var AccountService */
    private $accountService;

    /** @var CurrentAccountService */
    private $currentAccountService;
    
    /** @var PasswordVerifyService */
    private $passwordVerifyService;

    public function __construct(
        AccountService $accountService,
        CurrentAccountService $currentAccountService,
        PasswordVerifyService $passwordVerifyService
    ) {
        $this->accountService = $accountService;
        $this->currentAccountService = $currentAccountService;
        $this->passwordVerifyService = $passwordVerifyService;
    }

    public function auth(Account $account): Account
    {
        $_SESSION[SessionStrategy::SESSION_API_KEY] = $account->getAPIKey();

        $this->currentAccountService->signInWithAccount($account);

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
            new PasswordHasRequiredLength(),
            new HasSameAccount($this->accountService)
        ]);

        $account = $this->accountService->createAccount($email, $password);

        $this->auth($account);

        return $account;
    }

    public function signIn(SignInParameters $parameters) : Account
    {
        $email = $parameters->getEmail();
        $password = $parameters->getPassword();

        $account = $this->accountService->getByEmail($email);

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

        $oauth2Account = $this->accountService->findOAuthAccount(
            $registrationRequest->getProvider(),
            $registrationRequest->getProviderAccountId()
        );

        return $this->auth($oauth2Account->getAccount());
    }

    public function signOut()
    {
        $_SESSION[SessionStrategy::SESSION_API_KEY] = null;
    }

    public function verifyPassword(Account $account, string $password): bool
    {
        return $this->passwordVerifyService->verifyPassword($account, $password);
    }
}
