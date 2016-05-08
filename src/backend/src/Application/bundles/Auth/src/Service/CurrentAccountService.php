<?php
namespace Application\Auth\Service;

use Application\Auth\Middleware\AuthStrategy\Strategy;
use Application\Account\Entity\Account;
use Application\Account\Exception\AccountNotFoundException;
use Application\Account\Repository\AccountRepository;
use Application\Profile\Entity\Profile;

class CurrentAccountService
{
    /** @var AccountRepository */
    private $accountRepository;

    /** @var \Application\Account\Entity\Account */
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