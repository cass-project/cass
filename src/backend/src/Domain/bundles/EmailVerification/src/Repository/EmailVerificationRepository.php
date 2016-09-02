<?php
namespace CASS\Domain\EmailVerification\Repository;

use CASS\Domain\Account\Entity\Account;
use Doctrine\ORM\EntityRepository;
use CASS\Domain\EmailVerification\Entity\EmailVerification;

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