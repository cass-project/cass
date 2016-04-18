<?php
namespace Account\Service;

use Account\Entity\Account;
use Account\Entity\OAuthAccount;
use Account\Repository\AccountRepository;
use Account\Repository\OAuthAccountRepository;
use Profile\Entity\Profile;
use Profile\Entity\ProfileGreetings;
use Profile\Entity\ProfileImage;
use function Common\Util\generateRandomString;

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
        return generateRandomString($length);
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