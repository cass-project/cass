<?php
namespace Profile\Repository;

use Account\Entity\Account;
use Doctrine\ORM\EntityRepository;
use Profile\Entity\Profile;

class ProfileRepository extends EntityRepository
{
    public function attachProfileToAccount(Profile $profile, Account $account): Profile
    {
        $this->getEntityManager()->persist($profile);

        return $profile;
    }
}