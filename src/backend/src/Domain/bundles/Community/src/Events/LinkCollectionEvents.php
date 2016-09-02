<?php
namespace CASS\Domain\Community\Events;

use CASS\Application\Events\EventsBootstrapInterface;
use CASS\Application\Exception\PermissionsDeniedException;
use CASS\Domain\Auth\Service\CurrentAccountService;
use CASS\Domain\Collection\Entity\Collection;
use CASS\Domain\Collection\Service\CollectionService;
use CASS\Domain\Community\Service\CommunityService;
use Evenement\EventEmitterInterface;

final class LinkCollectionEvents implements EventsBootstrapInterface
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var CommunityService */
    private $communityService;

    /** @var CollectionService */
    private $collectionService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        CollectionService $collectionService,
        CommunityService $communityService
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->collectionService = $collectionService;
        $this->communityService = $communityService;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $currentAccountService = $this->currentAccountService;
        $communityService = $this->communityService;
        $collectionService = $this->collectionService;

        $collectionEvents = $collectionService->getEventEmitter();

        $collectionEvents->on(CollectionService::EVENT_COLLECTION_ACCESS, function(Collection $collection) use ($currentAccountService, $collectionService, $communityService)
        {
            if($collection->getOwnerType() === 'community') {
                $community = $communityService->getCommunityById((int) $collection->getOwnerId());

                if(! $currentAccountService->getCurrentAccount()->equals($community->getOwner())) {
                    throw new PermissionsDeniedException('You\'re not a community owner');
                }
            }
        });

        $collectionEvents->on(CollectionService::EVENT_COLLECTION_CREATED, function(Collection $collection) use ($collectionService, $communityService)
        {
            if($collection->getOwnerType() === 'community') {
                $communityService->linkCollection((int) $collection->getOwnerId(), $collection->getId());
            }
        });

        $collectionEvents->on(CollectionService::EVENT_COLLECTION_DELETE, function(Collection $collection) use ($collectionService, $communityService)
        {
            if($collection->getOwnerType() === 'community') {
                $communityService->unlinkCollection((int) $collection->getOwnerId(), $collection->getId());
            }
        });
    }
}