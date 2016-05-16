<?php
namespace Domain\Account\Scripts;

use Domain\Account\Entity\Account;
use Domain\Account\Repository\AccountRepository;

class DeleteAccountScript
{
    /** @var AccountRepository */
    private $accountRepository;

    public function __invoke(Account $account)
    {
        $accountId = $account->getId();
        $accountEmail = $account->getEmail();

        $this->accountRepository->deleteAccount($account);

        return [
            'id' => $accountId,
            'email' => $accountEmail,
            'entity' => $account
        ];
    }
}