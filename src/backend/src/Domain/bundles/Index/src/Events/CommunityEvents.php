<?php
namespace CASS\Domain\Bundles\Index\Events;

use CASS\Application\Events\EventsBootstrapInterface;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Community\Service\CommunityService;
use CASS\Domain\Bundles\Index\Service\IndexService;
use Evenement\EventEmitterInterface;

final class CommunityEvents implements EventsBootstrapInterface
{
    /** @var IndexService */
    private $indexService;

    /** @var CommunityService */
    private $communityService;
    
    public function __construct(IndexService $indexService, CommunityService $communityService)
    {
        $this->indexService = $indexService;
        $this->communityService = $communityService;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $is = $this->indexService;
        $cs = $this->communityService;

        $cs->getEventEmitter()->on(CommunityService::EVENT_COMMUNITY_CREATED, function(Community $community) use ($is, $cs) {
            $is->indexEntity($community);
        });

        $cs->getEventEmitter()->on(CommunityService::EVENT_COMMUNITY_UPDATED, function(Community $community) use ($is, $cs) {
            $is->indexEntity($community);
        });

        $cs->getEventEmitter()->on(CommunityService::EVENT_COMMUNITY_DELETE, function(Community $community) use ($is, $cs) {
            $is->excludeEntity($community);
        });
    }
}