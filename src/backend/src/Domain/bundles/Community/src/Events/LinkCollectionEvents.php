<?php
namespace Domain\Community\Events;

use Application\Exception\PermissionsDeniedException;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Service\CollectionService;
use Domain\Community\Service\CommunityService;

final class LinkCollectionEvents
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

    public function bindEvents()
    {
        $currentAccountService = $this->currentAccountService;
        $communityService = $this->communityService;
        $collectionService = $this->collectionService;

        $collectionEvents = $collectionService->getEventEmitter();

        $collectionEvents->on(CollectionService::EVENT_ACCESS, function(Collection $collection) use ($currentAccountService, $collectionService, $communityService)
        {
            if($collection->getOwnerType() === 'community') {
                $community = $communityService->getCommunityById((int) $collection->getOwnerId());

                if($community->getMetadata()['creatorAccountId'] !== $currentAccountService->getCurrentAccount()->getId()) {
                    throw new PermissionsDeniedException('You\'re not a community owner');
                }
            }
        });

        $collectionEvents->on(CollectionService::EVENT_CREATED, function(Collection $collection) use ($collectionService, $communityService)
        {
            if($collection->getOwnerType() === 'community') {
                $communityService->linkCollection((int) $collection->getOwnerId(), $collection->getId());
            }
        });

        $collectionEvents->on(CollectionService::EVENT_DELETE, function(Collection $collection) use ($collectionService, $communityService)
        {
            if($collection->getOwnerType() === 'community') {
                $communityService->unlinkCollection((int) $collection->getOwnerId(), $collection->getId());
            }
        });
    }
}