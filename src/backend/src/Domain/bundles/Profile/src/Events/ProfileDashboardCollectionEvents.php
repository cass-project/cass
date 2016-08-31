<?php
namespace Domain\Profile\Events;

use CASS\Application\Events\EventsBootstrapInterface;
use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Collection\Service\CollectionService;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Service\ProfileService;
use Evenement\EventEmitterInterface;

final class ProfileDashboardCollectionEvents implements EventsBootstrapInterface
{
    /** @var ProfileService */
    private $profileService;

    /** @var CollectionService */
    private $collectionService;

    public function __construct(ProfileService $profileService, CollectionService $collectionService)
    {
        $this->profileService = $profileService;
        $this->collectionService = $collectionService;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $this->profileService->getEventEmitter()->on(ProfileService::EVENT_PROFILE_CREATED, function(Profile $profile) {
            $collection = $this->collectionService->createCollection(new CreateCollectionParameters(
                sprintf('profile:%d', $profile->getId()),
                'Профиль',
                ''
            ), true);

            $this->collectionService->mainCollection($collection->getId());
        });
    }
}