<?php
namespace Domain\ProfileCommunities\Repository;

use Application\Exception\NotImplementedException;
use Doctrine\ORM\EntityRepository;
use Domain\ProfileCommunities\Entity\ProfileCommunityEQ;

class ProfileCommunitiesRepository extends EntityRepository
{
    public function joinToCommunity(int $profileId, int $communityId): ProfileCommunityEQ {
        throw new NotImplementedException;
    }

    public function leaveCommunity(int $profileId, int $communityId): ProfileCommunityEQ {
        throw new NotImplementedException;
    }

    public function getCommunitiesByProfile(int $profileId):array {
        throw new NotImplementedException;
    }
}