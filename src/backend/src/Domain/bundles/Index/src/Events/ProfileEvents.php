<?php
namespace Domain\Index\Events;

use CASS\Application\Events\EventsBootstrapInterface;
use Domain\Index\Service\IndexService;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Service\ProfileService;
use Evenement\EventEmitterInterface;

final class ProfileEvents implements EventsBootstrapInterface
{
    /** @var IndexService */
    private $indexService;

    /** @var ProfileService */
    private $profileService;

    public function __construct(IndexService $indexService, ProfileService $profileService)
    {
        $this->indexService = $indexService;
        $this->profileService = $profileService;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $is = $this->indexService;
        $ps = $this->profileService;

        $ps->getEventEmitter()->on(ProfileService::EVENT_PROFILE_CREATED, function(Profile $profile) use ($is) {
            $is->indexEntity($profile);
        });

        $ps->getEventEmitter()->on(ProfileService::EVENT_PROFILE_UPDATED, function(Profile $profile) use ($is) {
            $is->indexEntity($profile);
        });

        $ps->getEventEmitter()->on(ProfileService::EVENT_PROFILE_DELETE, function(Profile $profile) use ($is) {
            $is->excludeEntity($profile);
        });
    }

}