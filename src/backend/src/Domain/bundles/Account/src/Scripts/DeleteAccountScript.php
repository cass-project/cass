<?php
namespace CASS\Domain\Bundles\Account\Scripts;

use CASS\Domain\Bundles\Account\Entity\Account;
use CASS\Domain\Bundles\Account\Repository\AccountRepository;

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