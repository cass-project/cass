<?php
namespace Domain\ProfileCommunities\Service;

use Domain\Auth\Service\CurrentAccountService;
use Domain\ProfileCommunities\Entity\ProfileCommunityEQ;
use Domain\ProfileCommunities\Exception\AlreadyJoinedException;
use Domain\ProfileCommunities\Exception\AlreadyLeavedException;
use Domain\ProfileCommunities\Repository\ProfileCommunitiesRepository;

class ProfileCommunitiesService
{
    /** @var ProfileCommunitiesRepository */
    private $profileCommunitiesRepository;

    /** @var CurrentAccountService */
    private $currentAccountService;

    private function getCurrentProfileId(): int {
        return $this->currentAccountService->getCurrentProfile()->getId();
    }

    public function joinToCommunity(int $communityId): ProfileCommunityEQ {
        if($this->hasBookmarks($communityId)) {
            throw new AlreadyJoinedException(sprintf('You are already joined to this community'));
        }

        return $this->profileCommunitiesRepository->joinToCommunity(
            $this->getCurrentProfileId(),
            $communityId
        );
    }

    public function leaveCommunity(int $communityId) {
        if(! $this->hasBookmarks($communityId)) {
            throw new AlreadyLeavedException(sprintf('You are not joined to this community'));
        }

        return $this->profileCommunitiesRepository->leaveCommunity(
            $this->getCurrentProfileId(),
            $communityId
        );
    }

    public function getBookmarksOfCurrentProfile(): array {
        return $this->profileCommunitiesRepository->getEntitiesByProfile(
            $this->getCurrentProfileId()
        );
    }
    
    public function hasBookmarks(int $communityId): bool {
        return $this->profileCommunitiesRepository->hasBookmark($this->getCurrentProfileId(), $communityId);
    }
}