<?php
namespace CASS\Domain\Bundles\Profile\Service;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Profile\Entity\Profile;

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