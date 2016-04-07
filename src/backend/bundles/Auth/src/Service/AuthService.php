<?php
namespace Auth\Service;

use Auth\Middleware\AuthStrategy\SessionStrategy;
use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Auth\Service\AuthService\OAuth2\RegistrationRequest;
use Auth\Service\AuthService\SignUpValidation\ArePasswordsMatching;
use Auth\Service\AuthService\SignUpValidation\HasAllRequiredFields;
use Auth\Service\AuthService\SignUpValidation\HasSameAccount;
use Auth\Service\AuthService\SignUpValidation\IsEmailValid;
use Auth\Service\AuthService\SignUpValidation\PasswordHasRequiredLength;
use Auth\Service\AuthService\SignUpValidation\Validator as SignUpValidator;
use Data\Entity\Account;
use Data\Repository\AccountRepository;
use Data\Repository\OAuthAccountRepository;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthService
{
    /** @var AccountRepository */
    private $accountRepository;

    /** @var OAuthAccountRepository */
    private $oauthAccountRepository;

    /** @var array */
    private $oauth2Config;

    public function __construct(AccountRepository $accountRepository, OAuthAccountRepository $oAuthAccountRepository, array $oauth2Config)
    {
        $this->accountRepository = $accountRepository;
        $this->oauthAccountRepository = $oAuthAccountRepository;
        $this->oauth2Config = $oauth2Config;
    }

    public function auth(Account $account): Account
    {
        setcookie('api_key', $account->getAPIKey(), time() + 60 /* sec */ * 60 /* min */ * 24 /* hours */ * 30 /* days */, '/');
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

        return $this->auth($account);
    }

    public function signInOauth2(RegistrationRequest $registrationRequest)
    {
        $oauthRepository = $this->oauthAccountRepository;

        if(!$this->accountRepository->hasAccountWithEmail($registrationRequest->getEmail())) {
            $oauthRepository->create($registrationRequest);
        }

        $oauth2Account = $oauthRepository->findOAuthAccount($registrationRequest->getProvider(), $registrationRequest->getProviderAccountId());

        return $this->auth($oauth2Account->getAccount());
    }

    public function signOut()
    {
        unset($_COOKIE['api_key']);
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
