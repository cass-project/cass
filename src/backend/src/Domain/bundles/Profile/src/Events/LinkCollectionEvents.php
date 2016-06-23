<?php
namespace Domain\Profile\Events;

use Application\Events\EventsBootstrapInterface;
use Application\Exception\PermissionsDeniedException;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Service\CollectionService;
use Domain\Profile\Service\ProfileService;
use Evenement\EventEmitterInterface;

final class LinkCollectionEvents implements EventsBootstrapInterface
{
    /** @var CurrentAccountService */
    protected $currentAccountService;

    /** @var CollectionService */
    private $collectionService;

    /** @var ProfileService */
    private $profileService;
    
    public function __construct(
        CurrentAccountService $currentAccountService,
        CollectionService $collectionService,
        ProfileService $profileService
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->collectionService = $collectionService;
        $this->profileService = $profileService;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $currentAccountService = $this->currentAccountService;
        $profileService = $this->profileService;
        $collectionService = $this->collectionService;

        $collectionEvents = $collectionService->getEventEmitter();

        $collectionEvents->on(CollectionService::EVENT_COLLECTION_ACCESS, function(Collection $collection) use ($currentAccountService, $collectionService, $profileService) {
            if($collection->getOwnerType() === 'profile') {
                $profile = $profileService->getProfileById((int)$collection->getOwnerId());

                if(!$currentAccountService->getCurrentAccount()->getProfiles()->contains($profile)) {
                    throw new PermissionsDeniedException('You\'re not a profile owner');
                }
            }
        });

        $collectionEvents->on(CollectionService::EVENT_COLLECTION_CREATED, function(Collection $collection) use ($collectionService, $profileService) {
            if($collection->getOwnerType() === 'profile') {
                $profileService->linkCollection((int)$collection->getOwnerId(), $collection->getId());
            }
        });

        $collectionEvents->on(CollectionService::EVENT_COLLECTION_DELETE, function(Collection $collection) use ($collectionService, $profileService) {
            if($collection->getOwnerType() === 'profile') {
                $profileService->unlinkCollection((int)$collection->getOwnerId(), $collection->getId());
            }
        });
    }
}