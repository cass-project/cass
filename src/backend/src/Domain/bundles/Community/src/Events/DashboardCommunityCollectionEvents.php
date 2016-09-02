<?php
namespace CASS\Domain\Bundles\Community\Events;

use CASS\Application\Events\EventsBootstrapInterface;
use CASS\Domain\Bundles\Collection\Parameters\CreateCollectionParameters;
use CASS\Domain\Bundles\Collection\Service\CollectionService;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Community\Service\CommunityService;
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