<?php
namespace Domain\Profile\Service;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Profile\Entity\Profile;

final class WithProfileService
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var Profile */
    private $currentProfile;

    public function __construct(CurrentAccountService $currentProfileService)
    {
        $this->currentProfileService = $currentProfileService;
    }

    public function specifyProfile(int $profileId)
    {
         $this->currentProfile = $this->currentAccountService->getCurrentAccount()->getProfileWithId($profileId);
    }

    public function getProfile(): Profile
    {
        return $this->currentProfile;
    }
}