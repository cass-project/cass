<?php
namespace Domain\Account\Service;

use Domain\Account\Entity\Account;
use Domain\Account\Entity\OAuthAccount;
use Domain\Account\Exception\AccountHasDeleleRequestException;
use Domain\Account\Exception\InvalidOldPasswordException;
use Domain\Account\Repository\AccountRepository;
use Domain\Account\Repository\OAuthAccountRepository;
use Domain\Auth\Scripts\SetupProfileScript;
use Domain\Auth\Service\AuthService\OAuth2\RegistrationRequest;
use Domain\Auth\Service\PasswordVerifyService;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\ProfileGreetings;
use Domain\Profile\Entity\ProfileImage;
use Application\Util\GenerateRandomString;
use Domain\Profile\Repository\ProfileGreetingsRepository;

class AccountService
{
    /** @var AccountRepository */
    private $accountRepository;

    /** @var OAuthAccountRepository */
    private $oauthAccountRepository;

    /** @var ProfileGreetingsRepository */
    private $profileGreetingsRepository;

    /** @var PasswordVerifyService */
    private $passwordVerifyService;

    public function __construct(
        AccountRepository $accountRepository,
        OAuthAccountRepository $oauthAccountRepository,
        ProfileGreetingsRepository $profileGreetingsRepository,
        PasswordVerifyService $passwordVerifyService
    ) {
        $this->accountRepository = $accountRepository;
        $this->oauthAccountRepository = $oauthAccountRepository;
        $this->profileGreetingsRepository = $profileGreetingsRepository;
        $this->passwordVerifyService = $passwordVerifyService;
    }

    public function createAccount($email, $password = null): Account
    {
        $account = new Account();
        $account
            ->setEmail($email)
            ->setPassword($this->passwordVerifyService->generatePassword($password));

        $profile = new Profile($account);
        $profile
            ->setIsCurrent(true)
            ->setProfileGreetings(new ProfileGreetings($profile))
            ->setProfileImage(new ProfileImage($profile))
        ;

        $this->accountRepository->createAccount($account, $profile);

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

        $setupScript = new SetupProfileScript($provider, $resourceOwner, $profile->getProfileGreetings());
        $this->profileGreetingsRepository->saveGreetings( $setupScript->fetchProfileGreetings() );

        $oauthAccount = new OAuthAccount($account);
        $oauthAccount->setProvider($provider);
        $oauthAccount->setProviderAccountId($providerAccountId);

        $this->accountRepository->saveOAuth2Account($oauthAccount);

        return $account;
    }

    public function requestDelete(Account $account)
    {
        if($account->hasDeleteAccountRequest()) {
            throw new AccountHasDeleleRequestException(sprintf('Account `%s` already has delete request', $account->getEmail()));
        }

         $this->accountRepository->requestDelete($account);
    }

    public function cancelDeleteRequest(Account $account)
    {
        if($account->hasDeleteAccountRequest()) {
            $this->accountRepository->cancelDeleteRequest($account);
        }
    }

    public function findById(int $accountId): Account
    {
        return $this->accountRepository->findById($accountId);
    }

    public function findOAuthAccount(string $provider, string $providerAccountId): OAuthAccount
    {
        return $this->oauthAccountRepository->findOAuthAccount($provider, $providerAccountId);
    }

    public function deleteAccount(int $accountId): Account
    {
        $account = $this->findById($accountId);

        $this->accountRepository->deleteAccount($account);

        return $account;
    }

    public function changePassword(Account $account, string $oldPassword, string $newPassword): string
    {
        if(! $this->passwordVerifyService->verifyPassword($account, $oldPassword)) {
            throw new InvalidOldPasswordException('Invalid old password');
        }
        
        $newPassword = $this->passwordVerifyService->generatePassword($newPassword);
        
        $this->accountRepository->changePassword($account, $newPassword);

        return $newPassword;
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