<?php
namespace CASS\Domain\Bundles\Auth\Service;

use CASS\Domain\Bundles\Auth\Exception\NotAuthenticatedException;
use CASS\Domain\Bundles\Auth\Middleware\AuthStrategy\Strategy;
use CASS\Domain\Bundles\Account\Entity\Account;
use CASS\Domain\Bundles\Account\Exception\AccountNotFoundException;
use CASS\Domain\Bundles\Account\Repository\AccountRepository;

class CurrentAccountService
{
    /** @var \CASS\Domain\Bundles\Account\Entity\Account */
    private $account;

    /** @var AccountRepository */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function signInWithAccount(Account $account)
    {
        $this->account = $account;
    }

    public function signInWithStrategies(array $strategies)
    {
        /** @var Strategy[] $strategies */
        foreach($strategies as $strategy) {
            if($strategy->isAPIKeyAvailable()) {
                try {
                    $this->account = $this->accountRepository->findByAPIKey($strategy->getAPIKey());

                    return;
                } catch(AccountNotFoundException $e) {
                    throw new NotAuthenticatedException(sprintf('Invalid API Key with used strategy `%s`', get_class($strategy)));
                }
            }
        }

        throw new NotAuthenticatedException('No API Key available');
    }

    public function isAvailable(): bool
    {
        return $this->account !== null;
    }

    public function getCurrentAccount(): Account
    {
        return $this->account;
    }
    
    public function emptyToken()
    {
        $this->account = null;
    }
}