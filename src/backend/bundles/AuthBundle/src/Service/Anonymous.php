<?php
namespace Auth\Service;

use Data\Entity\Account;
use Data\Repository\AccountRepository;

class Anonymous
{
    /** @var AccountRepository */
    private $accountRepository;

    /** @var Account */
    private $anonymous;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function getAnonymousAccount(): Account
    {
        if($this->anonymous === null) {
            $this->anonymous = $this->accountRepository->findAnonymous();
        }

        return $this->anonymous;
    }
}