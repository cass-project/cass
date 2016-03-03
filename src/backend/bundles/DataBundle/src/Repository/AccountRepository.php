<?php
namespace Data\Repository;

use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Data\Entity\Account;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class AccountRepository extends EntityRepository
{
    public function findByLoginOrToken($login) : Account
    {
        try {
            return $this->createQueryBuilder('a')
                    ->where('a.email = :login OR a.phone = :phone OR a.token = :login')
                        ->setParameter('login', $login)
                        ->setParameter('phone', self::clearPhone($login))
                ->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            throw new InvalidCredentialsException('Fail to sign-in.');
        }
    }

    public function isAccountExist($email, $phone = null) : bool
    {
        return !!$this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->where('a.email = :email OR a.phone = :phone')
            ->setParameter('email', $email)
            ->setParameter('phone', self::clearPhone($phone))
            ->getQuery()->getSingleScalarResult();
    }

    public static function clearPhone(&$phone)
    {
        if ($phone) {
            $phone = preg_replace('~\D~', '', $phone);
            $phone = preg_replace('~^(\d{10})$~', '7$1', $phone);
            $phone = preg_replace('~^8~', '7', $phone);
        }

        return $phone;
    }
}