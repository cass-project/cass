<?php
namespace Domain\ProfileCommunities\Service;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Community\Repository\CommunityRepository;
use Domain\ProfileCommunities\Entity\ProfileCommunityEQ;
use Domain\ProfileCommunities\Exception\AlreadyJoinedException;
use Domain\ProfileCommunities\Exception\AlreadyLeavedException;
use Domain\ProfileCommunities\Repository\ProfileCommunitiesRepository;

class ProfileCommunitiesService
{
    /** @var CommunityRepository */
    private $communityRepository;

    /** @var ProfileCommunitiesRepository */
    private $profileCommunitiesRepository;

    /** @var CurrentAccountService */
    private $currentAccountService;

    public function __construct(
        CommunityRepository $communityRepository,
        ProfileCommunitiesRepository $profileCommunitiesRepository,
        CurrentAccountService $currentAccountService
    ) {
        $this->communityRepository = $communityRepository;
        $this->profileCommunitiesRepository = $profileCommunitiesRepository;
        $this->currentAccountService = $currentAccountService;
    }

    private function getCurrentProfileId(): int
    {
        return $this->currentAccountService->getCurrentProfile()->getId();
    }

    public function joinToCommunity(string $communitySID): ProfileCommunityEQ
    {
        $communityId = $this->communityRepository->getCommunityBySID($communitySID)->getId();

        if($this->hasBookmarks($communityId)) {
            throw new AlreadyJoinedException(sprintf('You are already joined to this community'));
        }

        return $this->profileCommunitiesRepository->joinToCommunity(
            $this->getCurrentProfileId(),
            $communityId
        );
    }

    public function leaveCommunity(string $communitySID)
    {

        $communityId = $this->communityRepository->getCommunityBySID($communitySID)->getId();

        if(!$this->hasBookmarks($communityId)) {
            throw new AlreadyLeavedException(sprintf('You are not joined to this community'));
        }

        return $this->profileCommunitiesRepository->leaveCommunity(
            $this->getCurrentProfileId(),
            $communityId
        );
    }

    public function getBookmarksOfCurrentProfile(): array
    {
        return $this->profileCommunitiesRepository->getEntitiesByProfile(
            $this->getCurrentProfileId()
        );
    }

    public function hasBookmarks(int $communityID): bool
    {
        return $this->profileCommunitiesRepository->hasBookmark($this->getCurrentProfileId(), $communityID);
    }
}