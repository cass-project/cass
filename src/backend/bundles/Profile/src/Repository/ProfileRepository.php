<?php
namespace Profile\Repository;

use Account\Entity\Account;
use Common\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Profile\Entity\Profile;

class ProfileRepository extends EntityRepository
{
    public function attachProfileToAccount(Profile $profile, Account $account): Profile
    {
        $this->getEntityManager()->persist($profile);

        return $profile;
    }

    public function getProfileById(int $profileId): Profile
    {
        $result = $this->find($profileId);

        if($result === null) {
            throw new EntityNotFoundException("Entity with ID {$profileId} not found");
        }

        return $result;
    }
}