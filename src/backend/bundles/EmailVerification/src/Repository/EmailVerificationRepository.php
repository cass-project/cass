<?php
namespace EmailVerification\Repository;

use Account\Entity\Account;
use Doctrine\ORM\EntityRepository;
use EmailVerification\Entity\EmailVerification;

class EmailVerificationRepository extends EntityRepository
{
    public function create(Account $forAccount, string $token)
    {
        $emailVerification = new EmailVerification($forAccount);
        $emailVerification->setToken($token);

        $em = $this->getEntityManager();
        $em->persist($emailVerification);
        $em->flush();
    }
}