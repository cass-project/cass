<?php
namespace Domain\Feed\Events;

use Application\Events\EventsBootstrapInterface;
use Domain\Community\Entity\Community;
use Domain\Community\Service\CommunityService;
use Domain\Feed\Factory\FeedSourceFactory;
use Domain\Feed\Service\EntityRouterService;
use Evenement\EventEmitterInterface;

final class CommunityEvents implements EventsBootstrapInterface
{
    /** @var CommunityService */
    private $communityService;

    /** @var EntityRouterService */
    private $entityRouterService;

    /** @var FeedSourceFactory */
    private $sourceFactory;

    public function __construct(
        CommunityService $communityService,
        EntityRouterService $entityRouterService,
        FeedSourceFactory $sourceFactory
    ) {
        $this->communityService = $communityService;
        $this->entityRouterService = $entityRouterService;
        $this->sourceFactory = $sourceFactory;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $cs = $this->communityService;
        $er = $this->entityRouterService;
        $sc = $this->sourceFactory;

        $cs->getEventEmitter()->on(CommunityService::EVENT_COMMUNITY_CREATED, function(Community $community) use ($cs, $er, $sc) {
            $er->upsert($community, [
                $sc->getPublicCommunitiesSource()
            ]);
        });

        $cs->getEventEmitter()->on(CommunityService::EVENT_COMMUNITY_UPDATED, function(Community $community) use ($cs, $er, $sc) {
            $er->upsert($community, [
                $sc->getPublicCommunitiesSource()
            ]);
        });

        $cs->getEventEmitter()->on(CommunityService::EVENT_COMMUNITY_DELETE, function(Community $community) use ($cs, $er, $sc) {
            $er->delete($community, [
                $sc->getPublicCommunitiesSource()
            ]);
        });
    }
}