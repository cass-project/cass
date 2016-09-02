<?php
namespace CASS\Domain\Account\Repository;

use Doctrine\ORM\EntityRepository;
use CASS\Domain\Account\Entity\Account;
use CASS\Domain\Account\Entity\AccountAppAccess;
use CASS\Domain\Account\Exception\AccountHasNoAppAccessEntryException;

final class AccountAppAccessRepository extends EntityRepository
{
    public function getAppAccess(Account $account): AccountAppAccess
    {
        if(! $this->hasAppAccess($account)) {
            throw new AccountHasNoAppAccessEntryException(sprintf('Account(ID: %s) has no app access', $account->getIdNoFall()));
        }

        return $this->findOneBy([
            'account' => $account
        ]);
    }
    
    public function hasAppAccess(Account $account): bool
    {
        return $this->findOneBy([
            'account' => $account
        ]) !== null;
    }

    public function saveAppAccess(AccountAppAccess $access)
    {
        if(! $access->isPersisted()) {
            $this->getEntityManager()->persist($access);
        }

        $this->getEntityManager()->flush($access);
    }

    public function destroyAppAccess(AccountAppAccess $access)
    {
        $this->getEntityManager()->remove($access);
        $this->getEntityManager()->flush($access);
    }
}