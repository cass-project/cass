<?php
namespace Domain\ProfileCommunities\Events;

use Application\Events\EventsBootstrapInterface;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Community\Entity\Community;
use Domain\Community\Service\CommunityService;
use Domain\ProfileCommunities\Service\ProfileCommunitiesService;
use Evenement\EventEmitterInterface;

final class CommunityEvents implements EventsBootstrapInterface
{
    /** @var CommunityService */
    private $communityService;

    /** @var ProfileCommunitiesService */
    private $profileCommunitiesService;

    public function __construct(
        CommunityService $communityService,
        ProfileCommunitiesService $profileCommunitiesService
    ) {
        $this->communityService = $communityService;
        $this->profileCommunitiesService = $profileCommunitiesService;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $this->communityService->getEventEmitter()->on(CommunityService::EVENT_COMMUNITY_CREATED, function(Community $community) {
            $this->profileCommunitiesService->joinToCommunity(
                $community->getOwner()->getCurrentProfile()->getId(),
                $community->getSID()
            );
        });
    }
}