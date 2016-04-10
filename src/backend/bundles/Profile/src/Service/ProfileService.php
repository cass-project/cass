<?php
namespace Profile\Service;

use Profile\Entity\Profile;
use Profile\Repository\ProfileRepository;

class ProfileService
{
    /** @var ProfileRepository */
    private $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function getProfileById(int $profileId): Profile
    {
        return $this->profileRepository->getProfileById($profileId);
    }

    public function nameFL(int $profileId, string $firstName, string $lastName)
    {
        $this->profileRepository->nameFL($profileId, $firstName, $lastName);
    }

    public function nameLFM(int $profileId, string $lastName, string $firstName, string $middleName)
    {
        $this->profileRepository->nameLFM($profileId, $lastName, $firstName, $middleName);
    }

    public function nameN(int $profileId, string $nickName)
    {
        $this->profileRepository->nameN($profileId, $nickName);
    }
}