<?php
namespace Domain\Account\Service;

use Domain\Account\Entity\Account;
use Domain\Account\Entity\AccountAppAccess;
use Domain\Account\Repository\AccountAppAccessRepository;

final class AccountAppAccessService
{
    /** @var AccountAppAccessRepository */
    private $accountAppAccessRepository;

    public function __construct(
        AccountAppAccessRepository $accountAppAccessRepository
    ) {
        $this->accountAppAccessRepository = $accountAppAccessRepository;
    }

    public function hasAppAccess(Account $account): bool
    {
        return $this->accountAppAccessRepository->hasAppAccess($account);
    }

    public function getAppAccess(Account $account): AccountAppAccess
    {
        return $this->accountAppAccessRepository->getAppAccess($account);
    }

    public function applyAppAccess(AccountAppAccess $access)
    {
        $this->accountAppAccessRepository->saveAppAccess($access);
    }

    public function getDefaultAppAccess(Account $account): AccountAppAccess
    {
        return new AccountAppAccess($account);
    }
}