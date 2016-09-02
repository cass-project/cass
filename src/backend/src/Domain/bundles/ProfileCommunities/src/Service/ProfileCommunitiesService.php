<?php
namespace CASS\Domain\Bundles\ProfileCommunities\Service;

use CASS\Domain\Bundles\Community\Repository\CommunityRepository;
use CASS\Domain\Bundles\ProfileCommunities\Entity\ProfileCommunityEQ;
use CASS\Domain\Bundles\ProfileCommunities\Exception\AlreadyJoinedException;
use CASS\Domain\Bundles\ProfileCommunities\Exception\AlreadyLeavedException;
use CASS\Domain\Bundles\ProfileCommunities\Repository\ProfileCommunitiesRepository;

class ProfileCommunitiesService
{
    /** @var CommunityRepository */
    private $communityRepository;

    /** @var ProfileCommunitiesRepository */
    private $profileCommunitiesRepository;

    public function __construct(
        CommunityRepository $communityRepository,
        ProfileCommunitiesRepository $profileCommunitiesRepository
    ) {
        $this->communityRepository = $communityRepository;
        $this->profileCommunitiesRepository = $profileCommunitiesRepository;
    }

    public function joinToCommunity(int $profileId, string $communitySID): ProfileCommunityEQ
    {
        $communityId = $this->communityRepository->getCommunityBySID($communitySID)->getId();

        if($this->hasBookmarks($profileId, $communityId)) {
            throw new AlreadyJoinedException(sprintf('You are already joined to this community'));
        }

        return $this->profileCommunitiesRepository->joinToCommunity(
            $profileId,
            $communityId
        );
    }

    public function leaveCommunity(int $profileId, string $communitySID)
    {

        $communityId = $this->communityRepository->getCommunityBySID($communitySID)->getId();

        if(!$this->hasBookmarks($profileId, $communityId)) {
            throw new AlreadyLeavedException(sprintf('You are not joined to this community'));
        }

        $this->profileCommunitiesRepository->leaveCommunity($profileId, $communityId);
    }

    public function getBookmarksOfProfile(int $profileId): array
    {
        return $this->profileCommunitiesRepository->getEntitiesByProfile($profileId);
    }

    public function hasBookmarks(int $profileId, int $communityID): bool
    {
        return $this->profileCommunitiesRepository->hasBookmark($profileId, $communityID);
    }
}