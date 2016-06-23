<?php
namespace Domain\Community\Events;

use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Collection\Service\CollectionService;
use Domain\Community\Entity\Community;
use Domain\Community\Service\CommunityService;

final class DashboardCommunityCollectionEvents
{
    /** @var CommunityService */
    private $communityService;

    /** @var CollectionService */
    private $collectionService;

    public function __construct(CommunityService $communityService, CollectionService $collectionService)
    {
        $this->communityService = $communityService;
        $this->collectionService = $collectionService;
    }

    public function bindEvents()
    {
        $communityService = $this->communityService;
        $collectionService = $this->collectionService;

        $communityService->getEventEmitter()->on(CommunityService::EVENT_COMMUNITY_CREATED, function(Community $community) use ($collectionService) {
            $collectionService->createCollection(new CreateCollectionParameters(
                sprintf('community:%s', $community->getId()),
                '$gt_community-feed_title',
                '$gt_community-feed_description',
                $community->hasTheme()
                    ? [$community->getTheme()->getId()]
                    : []
            ));
        });
    }
}