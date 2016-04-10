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
}