<?php
namespace Domain\Profile\Middleware\Command;

use Application\Command\Command as CommandInterface;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Service\ProfileService;

abstract class Command implements CommandInterface
{
    /** @var CurrentAccountService */
    protected $currentAccountService;

    /** @var ProfileService */
    protected $profileService;

    public function __construct(CurrentAccountService $currentAccountService, ProfileService $profileService)
    {
        $this->currentAccountService = $currentAccountService;
        $this->profileService = $profileService;
    }

    protected function validateProfileId($input): int
    {
        $isInteger = filter_var($input, FILTER_VALIDATE_INT);
        $isMoreThanZero = (int) $input > 0;

        if(!($isInteger && $isMoreThanZero)) {
            throw new \InvalidArgumentException('Invalid profileId');
        }

        return (int) $input;
    }

    protected function validateIsOwnProfile($profileId): bool
    {
        $profiles = $this->currentAccountService->getCurrentAccount()->getProfiles();


        foreach($profiles as $profile){
            if($profile instanceof Profile){
                if ($profile->getId() == $profileId) return TRUE;
            }
        }

        return false;
    }
}
