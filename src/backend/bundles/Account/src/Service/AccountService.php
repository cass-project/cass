<?php
namespace Account\Service;

use Auth\Entity\Account;
use Auth\Entity\OAuthAccount;
use Auth\Repository\AccountRepository;
use Profile\Entity\Profile;
use Profile\Entity\ProfileGreetings;
use Profile\Entity\ProfileImage;

class AccountService
{
    /** @var AccountRepository */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
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

    /** @see http://stackoverflow.com/questions/4356289/php-random-string-generator */
    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}