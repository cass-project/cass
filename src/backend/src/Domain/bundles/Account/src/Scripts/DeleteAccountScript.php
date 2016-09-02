<?php
namespace CASS\Domain\Account\Scripts;

use CASS\Domain\Account\Entity\Account;
use CASS\Domain\Account\Repository\AccountRepository;

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