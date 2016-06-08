<?php
namespace Domain\Auth\Service;

use Domain\Auth\Exception\NotAuthenticatedException;
use Domain\Auth\Middleware\AuthStrategy\Strategy;
use Domain\Account\Entity\Account;
use Domain\Account\Exception\AccountNotFoundException;
use Domain\Account\Repository\AccountRepository;
use Domain\Profile\Entity\Profile;

class CurrentAccountService
{
    /** @var AccountRepository */
    private $accountRepository;

    /** @var \Domain\Account\Entity\Account */
    private $account;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function isAvailable()
    {
        return $this->account !== null;
    }

    public function getCurrentAccount(): Account
    {
        return $this->account;
    }

    public function getCurrentProfile(): Profile
    {
        foreach($this->getCurrentAccount()->getProfiles() as $profile) {
            /** @var Profile $profile */
            if($profile->isCurrent()) {
                return $profile;
            }
        }

        throw new \Exception('No current profile is available');
    }

    public function forceSignIn(Account $account) {
        $this->account = $account;
    }

    public function emptyToken() {
        $this->account = null;
    }

    public function attempt(array $strategies)
    {
        /** @var Strategy[] $strategies */

        foreach($strategies as $strategy) {
            if($strategy->isAPIKeyAvailable()) {
                try {
                    $this->account = $this->accountRepository->findByAPIKey($strategy->getAPIKey());

                    return;
                }catch(AccountNotFoundException $e) {
                    throw new NotAuthenticatedException(sprintf('Invalid API Key with used strategy `%s`', get_class($strategy)));
                }
            }
        }

        throw new NotAuthenticatedException('No API Key available');
    }
}