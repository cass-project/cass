<?php
namespace Auth\Service;

use Auth\Middleware\AuthStrategy\Strategy;
use Account\Entity\Account;
use Account\Exception\AccountNotFoundException;
use Account\Repository\AccountRepository;
use Profile\Entity\Profile;

class CurrentAccountService
{
    /** @var AccountRepository */
    private $accountRepository;

    /** @var \Account\Entity\Account */
    private $account;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
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