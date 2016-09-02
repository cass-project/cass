<?php
namespace CASS\Domain\Auth\Service;

use CASS\Domain\Auth\Exception\NotAuthenticatedException;
use CASS\Domain\Auth\Middleware\AuthStrategy\Strategy;
use CASS\Domain\Account\Entity\Account;
use CASS\Domain\Account\Exception\AccountNotFoundException;
use CASS\Domain\Account\Repository\AccountRepository;

class CurrentAccountService
{
    /** @var \CASS\Domain\Account\Entity\Account */
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

    public function isAvailable()
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