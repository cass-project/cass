<?php
namespace CASS\Domain\Bundles\Account\Service;

use CASS\Application\Service\EventEmitterAware\EventEmitterAwareService;
use CASS\Application\Service\EventEmitterAware\EventEmitterAwareTrait;
use CASS\Domain\Bundles\Account\Entity\Account;
use CASS\Domain\Bundles\Account\Entity\OAuthAccount;
use CASS\Domain\Bundles\Account\Exception\AccountHasDeleteRequestException;
use CASS\Domain\Bundles\Account\Exception\AccountNotContainsProfileException;
use CASS\Domain\Bundles\Account\Exception\InvalidOldPasswordException;
use CASS\Domain\Bundles\Account\Repository\AccountRepository;
use CASS\Domain\Bundles\Account\Repository\OAuthAccountRepository;
use CASS\Domain\Bundles\Auth\Service\AuthService\OAuth2\RegistrationRequest;
use CASS\Domain\Bundles\Auth\Service\PasswordVerifyService;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Entity\Profile\Greetings;
use CASS\Util\GenerateRandomString;
use CASS\Domain\Bundles\Profile\Repository\ProfileRepository;
use CASS\Domain\Bundles\Profile\Service\ProfileService;

final class AccountService implements EventEmitterAwareService
{
    const EVENT_ACCOUNT_CREATED = 'domain.account.created';

    use EventEmitterAwareTrait;

    /** @var AccountRepository */
    private $accountRepository;

    /** @var ProfileRepository */
    private $profileRepository;

    /** @var ProfileService */
    private $profileService;

    /** @var OAuthAccountRepository */
    private $oauthAccountRepository;

    /** @var PasswordVerifyService */
    private $passwordVerifyService;

    public function __construct(
        AccountRepository $accountRepository,
        ProfileRepository $profileRepository,
        ProfileService $profileService,
        OAuthAccountRepository $oauthAccountRepository,
        PasswordVerifyService $passwordVerifyService
    )
    {
        $profileService->worksWithAccountService($this);

        $this->accountRepository = $accountRepository;
        $this->profileRepository = $profileRepository;
        $this->profileService = $profileService;
        $this->oauthAccountRepository = $oauthAccountRepository;
        $this->passwordVerifyService = $passwordVerifyService;
    }

    public function createAccount($email, $password = null): Account
    {
        $account = new Account();
        $account
            ->setEmail($email)
            ->setPassword($this->passwordVerifyService->generatePassword($password));

        while($this->checkAPIKeyCollision($account->getAPIKey())) {
            $account->regenerateAPIKey();
        }
        
        $this->accountRepository->createAccount($account);
        $this->getEventEmitter()->emit(self::EVENT_ACCOUNT_CREATED, [$account]);
        
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

        return $account->getAPIKey();
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

        array_map(function(Profile $profile) {
            $this->profileRepository->saveProfile($profile);
        }, $account->getProfiles()->toArray());


        return $account;
    }

    public function checkAPIKeyCollision(string $apiKey): bool
    {
        return $this->accountRepository->hasAccountWithAPIKey($apiKey);
    }

    public function regenerateAPIKey(int $accountId): string
    {
        $account = $this->getById($accountId);

        do {
            $account->regenerateAPIKey();
        } while($this->checkAPIKeyCollision($account->getAPIKey()));

        $this->accountRepository->saveAccount($account);

        return $account->getAPIKey();
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