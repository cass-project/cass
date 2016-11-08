<?php
namespace CASS\Domain\Bundles\Profile\Events;

use CASS\Application\Events\EventsBootstrapInterface;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Service\ProfileCardService;
use CASS\Domain\Bundles\Profile\Service\ProfileService;
use Evenement\EventEmitterInterface;

final class ProfileCardEvents implements EventsBootstrapInterface
{
    /** @var ProfileService */
    private $profileService;

    /** @var ProfileCardService */
    private $profileCardService;

    public function __construct(ProfileService $profileService, ProfileCardService $profileCardService)
    {
        $this->profileService = $profileService;
        $this->profileCardService = $profileCardService;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $this->profileService->getEventEmitter()->on(ProfileService::EVENT_PROFILE_CREATED, function(Profile $profile) {
            $this->profileCardService->saveProfileCard($profile, $this->profileCardService->createInitialProfileCard($profile));
        });
    }
}