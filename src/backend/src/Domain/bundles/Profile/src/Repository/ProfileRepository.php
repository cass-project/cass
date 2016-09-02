<?php
namespace CASS\Domain\Profile\Repository;

use Doctrine\ORM\EntityRepository;
use CASS\Domain\Profile\Entity\Profile;
use CASS\Domain\Profile\Entity\Profile\Greetings;
use CASS\Domain\Profile\Exception\ProfileNotFoundException;

class ProfileRepository extends EntityRepository
{
    public function createProfile(Profile $profile): Profile
    {
        $em = $this->getEntityManager();

        if ($profile->isPersisted()) {
            throw new \Exception('Attempt to recreate profile entity');
        }

        $em->persist($profile);
        $em->flush($profile);

        return $profile;
    }

    public function saveProfile(Profile $profile): Profile
    {
        $this->getEntityManager()->flush($profile);

        return $profile;
    }

    public function deleteProfile(Profile $profile)
    {
        $this->getEntityManager()->remove($profile);
        $this->getEntityManager()->flush($profile);
    }

    public function getProfileById(int $profileId): Profile
    {
        $result = $this->find($profileId);

        if ($result === null) {
            throw new ProfileNotFoundException("Entity with ID {$profileId} not found");
        }

        return $result;
    }

    public function getProfileBySID(string $profileSID): Profile
    {
        $result = $this->findOneBy([
            'sid' => $profileSID
        ]);

        if ($result === null) {
            throw new ProfileNotFoundException("Entity with SID {$profileSID} not found");
        }

        return $result;
    }

    public function getProfileByIds(array $profileIds): array
    {
        $profileIds = array_filter($profileIds, 'is_integer');

        if (!count($profileIds)) {
            throw new \Exception('No profile ids available');
        }

        /** @var Profile[] $result */
        $result = $this->findBy([
            'id' => $profileIds
        ]);

        return $result;
    }

    public function loadProfilesByIds(array $profileIds)
    {
        $this->findBy([
            'id' => $profileIds
        ]);
    }
}