<?php
namespace CASS\Domain\Bundles\Profile\Events;

use CASS\Application\Events\EventsBootstrapInterface;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Entity\ProfileInterestingInEQ;
use CASS\Domain\Bundles\Profile\Repository\ProfileInterestingInEQRepository;
use CASS\Domain\Bundles\Profile\Repository\ProfileRepository;
use CASS\Domain\Bundles\Profile\Service\ProfileService;
use CASS\Domain\Bundles\Theme\Entity\Theme;
use CASS\Domain\Bundles\Theme\Service\ThemeService;
use Evenement\EventEmitterInterface;

final class ProfileInterestingInEQEvents implements EventsBootstrapInterface
{
    /** @var ThemeService */
    private $themeService;

    /** @var ProfileService */
    private $profileService;

    /** @var ProfileRepository */
    private $profileRepository;

    /** @var ProfileInterestingInEQRepository */
    private $eq;


    public function __construct(
        ThemeService $themeService,
        ProfileService $profileService,
        ProfileRepository $profileRepository,
        ProfileInterestingInEQRepository $eq
    ) {
        $this->themeService = $themeService;
        $this->profileService = $profileService;
        $this->profileRepository = $profileRepository;
        $this->eq = $eq;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $eq = $this->eq;
        $profileService = $this->profileService;
        $themeService = $this->themeService;

        $themeService->getEventEmitter()->on(ThemeService::EVENT_DELETE, function(Theme $theme) use ($eq, $profileService) {
            array_reduce($eq->getProfilesByThemeId($theme->getId()), function(ProfileInterestingInEQ $eq) use ($profileService) {
                $profile = $profileService->getProfileById($eq->getProfileId());
                $profile->setInterestingInIds(array_filter($profile->getInterestingInIds(), function($input) use ($eq) {
                    return (int) $input !== (int) $eq->getThemeId();
                }));
            });

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