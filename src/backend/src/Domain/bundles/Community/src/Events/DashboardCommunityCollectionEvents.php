<?php
namespace Domain\Community\Events;

use Application\Events\EventsBootstrapInterface;
use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Collection\Service\CollectionService;
use Domain\Community\Entity\Community;
use Domain\Community\Service\CommunityService;
use Evenement\EventEmitterInterface;

final class DashboardCommunityCollectionEvents implements EventsBootstrapInterface
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

    public function up(EventEmitterInterface $globalEmitter)
    {
        $communityService = $this->communityService;
        $collectionService = $this->collectionService;

        $communityService->getEventEmitter()->on(CommunityService::EVENT_COMMUNITY_CREATED, function(Community $community) use ($collectionService) {
            $collection = $collectionService->createCollection(new CreateCollectionParameters(
                sprintf('community:%s', $community->getId()),
                'Сообщество',
                'Лента сообщества',
                $community->hasTheme()
                    ? [$community->getTheme()->getId()]
                    : []
            ));

            $collectionService->mainCollection($collection->getId());
        });
    }
}