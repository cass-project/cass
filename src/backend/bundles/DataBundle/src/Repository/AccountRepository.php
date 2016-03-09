<?php
namespace Data\Repository;

use Data\Entity\Account;
use Data\Exception\Auth\AccountNotFoundException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class AccountRepository extends EntityRepository
{
    public function findByEmail($email) : Account
    {
        try {
            return $this->createQueryBuilder('a')
                ->where('a.email = :email')
                ->setParameter("email", $email)
                ->getQuery()
                ->getSingleResult()
            ;
        }catch (NoResultException $e) {
            throw new AccountNotFoundException(sprintf('Account with email `%s` not found', $email));
        }
    }

    public function hasAccountWithEmail($email) : bool
    {
        try {
            $this->findByEmail($email);

            return true;
        }catch(AccountNotFoundException $e) {
            return false;
        }
    }

    public function saveAccount(Account $account)
    {
        $this->getEntityManager()->persist($account);
        $this->getEntityManager()->flush($account);
    }
}