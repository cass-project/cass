<?php
namespace Domain\Feed\Events;

use Application\Events\EventsBootstrapInterface;
use Domain\Feed\Factory\FeedSourceFactory;
use Domain\Feed\Service\EntityRouterService;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Service\ProfileService;
use Evenement\EventEmitterInterface;

final class ProfileEvents implements EventsBootstrapInterface
{
    /** @var ProfileService */
    private $profileService;

    /** @var EntityRouterService */
    private $entityRouterService;

    /** @var FeedSourceFactory */
    private $sourceFactory;

    public function __construct(
        ProfileService $profileService,
        EntityRouterService $entityRouterService,
        FeedSourceFactory $sourceFactory
    ) {
        $this->profileService = $profileService;
        $this->entityRouterService = $entityRouterService;
        $this->sourceFactory = $sourceFactory;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $ps = $this->profileService;
        $er = $this->entityRouterService;
        $sc = $this->sourceFactory;

        $ps->getEventEmitter()->on(ProfileService::EVENT_PROFILE_CREATED, function(Profile $profile) use ($er, $ps, $sc) {
            $er->upsert($profile, [
                $sc->getPublicProfilesSource(),
                $sc->getPublicExpertsSource(),
            ]);
        });

        $ps->getEventEmitter()->on(ProfileService::EVENT_PROFILE_UPDATED, function(Profile $profile) use ($er, $ps, $sc) {
            $er->upsert($profile, [
                $sc->getPublicProfilesSource(),
                $sc->getPublicExpertsSource(),
            ]);
        });

        $ps->getEventEmitter()->on(ProfileService::EVENT_PROFILE_DELETE, function(Profile $profile) use ($er, $ps, $sc) {
            $er->delete($profile, [
                $sc->getPublicProfilesSource(),
                $sc->getPublicExpertsSource(),
            ]);
        });
    }
}