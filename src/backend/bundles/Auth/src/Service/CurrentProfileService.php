<?php
namespace Auth\Service;

use Auth\Middleware\AuthStrategy\Strategy;
use Auth\Entity\Account;
use Data\Exception\Auth\AccountNotFoundException;
use Auth\Repository\AccountRepository;
use Psr\Http\Message\ServerRequestInterface;

class CurrentProfileService
{
    /** @var AccountRepository */
    private $accountRepository;

    /** @var Account */
    private $account;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function getCurrentAccount(): Account {
        return $this->account;
    }

    /**
     * @param Strategy[] $strategies
     * @throws NotAuthenticatedException
     */
    public function attempt(array $strategies)
    {
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