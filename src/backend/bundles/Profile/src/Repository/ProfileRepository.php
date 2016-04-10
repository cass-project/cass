<?php
namespace Profile\Repository;

use Account\Entity\Account;
use Common\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Profile\Entity\Profile;
use Profile\Entity\ProfileGreetings;

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

    public function nameFL(int $profileId, string $firstName, string $lastName)
    {
        $em = $this->getEntityManager();

        $greetings = $this->getProfileById($profileId)->getProfileGreetings();
        $greetings
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setGreetingsMethod(ProfileGreetings::GREETINGS_FL);

        $em->persist($greetings);
        $em->flush($greetings);
    }

    public function nameLFM(int $profileId, string $lastName, string $firstName, string $middleName)
    {
        $em = $this->getEntityManager();

        $greetings = $this->getProfileById($profileId)->getProfileGreetings();
        $greetings
            ->setLastName($lastName)
            ->setFirstName($firstName)
            ->setMiddleName($middleName)
            ->setGreetingsMethod(ProfileGreetings::GREETINGS_LFM);

        $em->persist($greetings);
        $em->flush($greetings);
    }

    public function nameN(int $profileId, string $nickName)
    {
        $em = $this->getEntityManager();

        $greetings = $this->getProfileById($profileId)->getProfileGreetings();
        $greetings
            ->setNickName($nickName)
            ->setGreetingsMethod(ProfileGreetings::GREETINGS_N);

        $em->persist($greetings);
        $em->flush($greetings);
    }
}