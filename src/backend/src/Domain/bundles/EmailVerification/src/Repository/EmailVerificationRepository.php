<?php
namespace Domain\EmailVerification\Repository;

use Domain\Account\Entity\Account;
use Doctrine\ORM\EntityRepository;
use Domain\EmailVerification\Entity\EmailVerification;

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