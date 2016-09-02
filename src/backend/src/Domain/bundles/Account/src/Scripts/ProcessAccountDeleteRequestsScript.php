<?php
namespace CASS\Domain\Bundles\Account\Scripts;

use CASS\Domain\Bundles\Account\Entity\Account;
use CASS\Domain\Bundles\Account\Repository\AccountRepository;

class ProcessAccountDeleteRequestsScript
{
    const DAYS_TO_ACCEPT_REQUEST = 7;

    /** @var DeleteAccountScript */
    private $deleteAccountScript;

    /** @var AccountRepository */
    private $accountRepository;

    public function __construct(DeleteAccountScript $deleteAccountScript, AccountRepository $accountRepository)
    {
        $this->deleteAccountScript = $deleteAccountScript;
        $this->accountRepository = $accountRepository;
    }

    public function __invoke()
    {
        $deleteScript = $this->deleteAccountScript;

        return array_map(function (Account $account) use ($deleteScript) {
            return $deleteScript($account);
        }, $this->accountRepository->getPendingDeleteAccounts(self::DAYS_TO_ACCEPT_REQUEST));
    }
}