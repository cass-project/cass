<?php
namespace Domain\Profile\Events;

use Domain\Profile\Entity\Profile;
use Domain\Profile\Repository\ProfileInterestingInEQRepository;
use Domain\Profile\Service\ProfileService;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Service\ThemeService;

final class ProfileInterestingInEQEvents
{
    /** @var ThemeService */
    private $themeService;

    /** @var ProfileService */
    private $profileService;

    /** @var ProfileInterestingInEQRepository */
    private $eq;

    public function __construct(
        ThemeService $themeService,
        ProfileService $profileService,
        ProfileInterestingInEQRepository $eq
    ) {
        $this->themeService = $themeService;
        $this->profileService = $profileService;
        $this->eq = $eq;
    }

    public function bindEvents()
    {
        $eq = $this->eq;
        $profileService = $this->profileService;
        $themeService = $this->themeService;

        $themeService->getEventEmitter()->on(ThemeService::EVENT_DELETE, function(Theme $theme) use ($eq) {
            $eq->deleteEQOfTheme($theme->getId());
        });

        $profileService->getEventEmitter()->on(ProfileService::EVENT_PROFILE_CREATED, function(Profile $profile) use ($eq) {
            $eq->sync($profile->getId(), $profile->getInterestingInIds());
        });

        $profileService->getEventEmitter()->on(ProfileService::EVENT_PROFILE_UPDATED, function(Profile $profile) use ($eq) {
            $eq->sync($profile->getId(), $profile->getInterestingInIds());
        });

        $profileService->getEventEmitter()->on(ProfileService::EVENT_PROFILE_DELETE, function(Profile $profile) use ($eq) {
            $eq->deleteEQOfProfile($profile->getId());
        });
    }
}