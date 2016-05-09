<?php
namespace Domain\ProfileCommunities\Service;

use Domain\Auth\Service\CurrentAccountService;
use Domain\ProfileCommunities\Entity\ProfileCommunityEQ;
use Domain\ProfileCommunities\Repository\ProfileCommunitiesRepository;

class ProfileCommunitiesService
{
    /** @var ProfileCommunitiesRepository */
    private $profileCommunitiesRepository;

    /** @var CurrentAccountService */
    private $currentAccountService;

    public function joinToCommunity(int $communityId): ProfileCommunityEQ {
        return $this->profileCommunitiesRepository->joinToCommunity(
            $this->currentAccountService->getCurrentProfile()->getId(),
            $communityId
        );
    }

    public function leaveCommunity(int $communityId): ProfileCommunityEQ {
        return $this->profileCommunitiesRepository->leaveCommunity(
            $this->currentAccountService->getCurrentProfile()->getId(),
            $communityId
        );
    }

    public function getCommunitiesByProfile(): array {
        return $this->profileCommunitiesRepository->getCommunitiesByProfile(
            $this->currentAccountService->getCurrentProfile()->getId()
        );
    }
}