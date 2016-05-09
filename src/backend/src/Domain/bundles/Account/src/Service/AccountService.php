<?php
namespace Domain\Account\Service;

use Domain\Account\Entity\Account;
use Domain\Account\Entity\OAuthAccount;
use Domain\Account\Repository\AccountRepository;
use Domain\Account\Repository\OAuthAccountRepository;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\ProfileGreetings;
use Domain\Profile\Entity\ProfileImage;
use Application\Util\GenerateRandomString;

class AccountService
{
    /** @var AccountRepository */
    private $accountRepository;

    /** @var OAuthAccountRepository */
    private $oauthAccountRepository;

    public function __construct(AccountRepository $accountRepository, OAuthAccountRepository $oauthAccountRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->oauthAccountRepository = $oauthAccountRepository;
    }

    public function createAccount($email, $password = null): Account
    {
        $account = new Account();
        $account
            ->setEmail($email)
            ->setPassword($password);

        $profile = new Profile($account);
        $profile
            ->setIsCurrent(true)
            ->setProfileGreetings(new ProfileGreetings($profile))
            ->setProfileImage(new ProfileImage($profile))
        ;

        $this->accountRepository->saveAccount($account, $profile);

        return $account;
    }

    public function createOAuth2Account(string $email, string $provider, $providerAccountId): Account
    {
        $account = $this->createAccount($email, $this->generateRandomString(32));
        $profile = $account->getProfiles()->first();

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