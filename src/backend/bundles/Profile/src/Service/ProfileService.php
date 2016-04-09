<?php
namespace Profile\Service;

use Auth\Entity\Account;
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

    public function createProfileForAccount(Account $account): Profile
    {
        return $this->profileRepository->attachProfileToAccount(new Profile($account), $account);
    }
}