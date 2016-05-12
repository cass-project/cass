<?php
namespace Domain\Account\Service;

use Domain\Account\Entity\Account;
use Domain\Account\Entity\OAuthAccount;
use Domain\Account\Repository\AccountRepository;
use Domain\Account\Repository\OAuthAccountRepository;
use Domain\Auth\Scripts\SetupProfile\SetupProfileScript;
use Domain\Auth\Service\AuthService\OAuth2\RegistrationRequest;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\ProfileGreetings;
use Domain\Profile\Entity\ProfileImage;
use Application\Util\GenerateRandomString;
use Domain\Profile\Repository\ProfileGreetingsRepository;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class AccountService
{
    /** @var AccountRepository */
    private $accountRepository;

    /** @var OAuthAccountRepository */
    private $oauthAccountRepository;

    /** @var ProfileGreetingsRepository */
    private $profileGreetingsRepository;

    public function __construct(AccountRepository $accountRepository, OAuthAccountRepository $oauthAccountRepository,ProfileGreetingsRepository $profileGreetingsRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->oauthAccountRepository = $oauthAccountRepository;
        $this->profileGreetingsRepository = $profileGreetingsRepository;
    }

    public function createAccount($email, $password = null): Account
    {
        $account = new Account();
        $account
            ->setEmail($email)
            ->setPassword(password_hash($password, PASSWORD_DEFAULT));

        $profile = new Profile($account);
        $profile
            ->setIsCurrent(true)
            ->setProfileGreetings(new ProfileGreetings($profile))
            ->setProfileImage(new ProfileImage($profile))
        ;

        $this->accountRepository->saveAccount($account, $profile);

        return $account;
    }

    public function createOAuth2Account(RegistrationRequest $registrationRequest): Account
    {
        $email             = $registrationRequest->getEmail();
        $provider          = $registrationRequest->getProvider();
        $providerAccountId = $registrationRequest->getProviderAccountId();
        $resourceOwner     = $registrationRequest->getResourceOwner();

        $account = $this->createAccount($email, $this->generateRandomString(32));

        /** @var Profile $profile */
        $profile = $account->getProfiles()->first();

//        $setupScript = new SetupProfileScript($resourceOwner, $profile);
//        $greeting = $setupScript->fetchProfileGreetings();
//        $this->profileGreetingsRepository->saveGreetings($greeting);

        $oauthAccount = new OAuthAccount($account);
        $oauthAccount->setProvider($provider);
        $oauthAccount->setProviderAccountId($providerAccountId);

        $this->accountRepository->saveOAuth2Account($oauthAccount);

        return $account;
    }

    public function findOAuthAccount(string $provider, string $providerAccountId): OAuthAccount
    {
        return $this->oauthAccountRepository->findOAuthAccount($provider, $providerAccountId);
    }


    private function generateRandomString($length = 10)
    {
        return GenerateRandomString::gen($length);
    }

    public function hasAccountWithEmail(string $email)
    {
        return $this->accountRepository->hasAccountWithEmail($email);
    }

    public function findByEmail(string $email): Account
    {
        return $this->accountRepository->findByEmail($email);
    }
}