<?php
namespace Data\Repository;

use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Data\Entity\Account;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class AccountRepository extends EntityRepository
{
    function findByLoginOrToken($login) : Account
    {
        try {
            return $this->createQueryBuilder('a')
                    ->where('a.email = :login OR a.phone = :login OR a.token = :login')
                        ->setParameter("login", $login)
                ->getQuery()->getSingleResult();
        }catch (NoResultException $e) {
            throw new InvalidCredentialsException("Fail to sign-in.");
        }
    }

    function isAccountExist($login) : bool
    {
        return !!$this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->where('a.email = :login OR a.phone = :login')
            ->setParameter("login", $login)->getQuery()->getSingleScalarResult();
    }
}