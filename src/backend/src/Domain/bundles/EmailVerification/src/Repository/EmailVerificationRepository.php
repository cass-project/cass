<?php
namespace CASS\Domain\Bundles\EmailVerification\Repository;

use CASS\Domain\Bundles\Account\Entity\Account;
use Doctrine\ORM\EntityRepository;
use CASS\Domain\Bundles\EmailVerification\Entity\EmailVerification;

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