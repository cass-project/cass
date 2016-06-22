<?php
namespace Domain\Account\Service;

use Domain\Account\Entity\Account;
use Domain\Account\Entity\OAuthAccount;
use Domain\Account\Exception\AccountHasDeleteRequestException;
use Domain\Account\Exception\AccountNotContainsProfileException;
use Domain\Account\Exception\InvalidOldPasswordException;
use Domain\Account\Repository\AccountRepository;
use Domain\Account\Repository\OAuthAccountRepository;
use Domain\Auth\Service\AuthService\OAuth2\RegistrationRequest;
use Domain\Auth\Service\PasswordVerifyService;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\Profile\Greetings;
use Application\Util\GenerateRandomString;
use Domain\Profile\Service\ProfileService;
use Evenement\EventEmitter;
use Evenement\EventEmitterInterface;

class AccountService
{
    const EVENT_ACCOUNT_CREATED = 'domain.account.created';

    /** @var EventEmitterInterface */
    private $events;

    /** @var AccountRepository */
    private $accountRepository;

    /** @var ProfileService */
    private $profileService;

    /** @var OAuthAccountRepository */
    private $oauthAccountRepository;

    /** @var PasswordVerifyService */
    private $passwordVerifyService;

    public function __construct(
        AccountRepository $accountRepository,
        ProfileService $profileService,
        OAuthAccountRepository $oauthAccountRepository,
        PasswordVerifyService $passwordVerifyService
    )
    {
        $profileService->worksWithAccountService($this);

        $this->events = new EventEmitter();
        $this->accountRepository = $accountRepository;
        $this->profileService = $profileService;
        $this->oauthAccountRepository = $oauthAccountRepository;
        $this->passwordVerifyService = $passwordVerifyService;
    }

    public function getEventEmitter(): EventEmitterInterface
    {
        return $this->events;
    }

    public function createAccount($email, $password = null): Account
    {
        $account = new Account();
        $account
            ->setEmail($email)
            ->setPassword($this->passwordVerifyService->generatePassword($password));
        
        $this->accountRepository->createAccount($account);
        $this->events->emit(self::EVENT_ACCOUNT_CREATED, [$account]);
        
        $this->profileService->createProfileForAccount($account);
        $this->accountRepository->saveAccount($account);

        return $account;
    }

    public function createOAuth2Account(RegistrationRequest $registrationRequest): Account
    {
        $email = $registrationRequest->getEmail();
        $provider = $registrationRequest->getProvider();
        $providerAccountId = $registrationRequest->getProviderAccountId();

        $account = $this->createAccount($email, GenerateRandomString::gen(32));

        $oauthAccount = new OAuthAccount($account);
        $oauthAccount->setProvider($provider);
        $oauthAccount->setProviderAccountId($providerAccountId);

        $this->accountRepository->createOAuth2Account($oauthAccount);

        return $account;
    }

    public function switchTo(Account $account, Profile $switchToProfile): Profile
    {
        if (!$account->getProfiles()->contains($switchToProfile)) {
            throw new AccountNotContainsProfileException(sprintf(
                'Account (ID: %s) does\'nt contains profile (ID: %s)',
                $account->isPersisted() ? $account->getId() : '#NEW_ACCOUNT',
                $switchToProfile->isPersisted() ? $switchToProfile->getId() : '#NEW_PROFILE'
            ));
        }

        $account->getProfiles()->forAll(function (Profile $profile) use ($switchToProfile) {
            $profile === $switchToProfile
                ? $profile->setAsCurrent()
                : $profile->unsetAsCurrent();
        });

        $this->accountRepository->saveAccount($account);

        return $switchToProfile;
    }

    public function requestDelete(Account $account): Account
    {
        if ($account->hasDeleteAccountRequest()) {
            throw new AccountHasDeleteRequestException(sprintf('Account `%s` already has delete request', $account->getEmail()));
        }

        $account->requestAccountDelete();

        $this->accountRepository->saveAccount($account);

        return $account;
    }

    public function cancelDeleteRequest(Account $account): Account
    {
        if ($account->hasDeleteAccountRequest()) {
            $account->cancelAccountRequestDelete();

            $this->accountRepository->saveAccount($account);
        }

        return $account;
    }

    public function deleteAccount(int $accountId): Account
    {
        $account = $this->getById($accountId);

        $this->accountRepository->deleteAccount($account);

        return $account;
    }

    public function changePassword(Account $account, string $oldPassword, string $newPassword): string
    {
        if (!$this->passwordVerifyService->verifyPassword($account, $oldPassword)) {
            throw new InvalidOldPasswordException('Invalid old password');
        }

        $account->setPassword($this->passwordVerifyService->generatePassword($newPassword));

        $this->accountRepository->saveAccount($account);

        return $newPassword;
    }

    public function switchToProfile(Account $account, int $switchToProfileId): Account
    {
        if(! $account->getProfiles()->filter(function(Profile $profile) use ($switchToProfileId) {
            return $profile->getId() === $switchToProfileId;
        })->count()) {
            throw new AccountNotContainsProfileException(sprintf('Profile (ID: %s) is not exists', $switchToProfileId));
        };

        $account->getProfiles()->map(function(Profile $profile) use($switchToProfileId, &$found) {
            $profile->getId() === $switchToProfileId
                ? $profile->setAsCurrent()
                : $profile->unsetAsCurrent();
        });

        $this->accountRepository->saveAccount($account);

        return $account;
    }

    public function getById(int $accountId): Account
    {
        return $this->accountRepository->getById($accountId);
    }

    public function findOAuthAccount(string $provider, string $providerAccountId): OAuthAccount
    {
        return $this->oauthAccountRepository->findOAuthAccount($provider, $providerAccountId);
    }

    public function hasAccountWithEmail(string $email): bool
    {
        return $this->accountRepository->hasAccountWithEmail($email);
    }

    public function getByEmail(string $email): Account
    {
        return $this->accountRepository->getByEmail($email);
    }
}