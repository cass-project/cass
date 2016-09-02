<?php
namespace CASS\Domain\Bundles\Community\Repository;

use CASS\Domain\Bundles\Community\Entity\Community;
use Doctrine\ORM\EntityRepository;
use CASS\Domain\Bundles\Community\Exception\CommunityNotFoundException;

class CommunityRepository extends EntityRepository
{
    public function createCommunity(Community $community): Community
    {
        $this->getEntityManager()->persist($community);
        $this->getEntityManager()->flush($community);

        return $community;
    }

    public function saveCommunity(Community $community): Community
    {
        $this->getEntityManager()->flush($community);

        return $community;
    }

    public function getCommunityById(int $communityId): Community
    {
        $entity = $this->find($communityId);

        if($entity === null) {
            throw new CommunityNotFoundException(sprintf('Community with ID `%s` not found', $communityId));
        }

        return $entity;
    }

    public function getCommunityBySID(string $communitySID): Community
    {
        $entity = $this->findOneBy([
            'sid' => $communitySID
        ]);

        if($entity === null) {
            throw new CommunityNotFoundException(sprintf('Community with SID `%s` not found', $communitySID));
        }

        return $entity;
    }

    public function loadCommunitiesByIds(array $communityIds)
    {
        $this->findBy([
            'id' => $communityIds
        ]);
    }

    public function deleteCommunity(Community $community)
    {
        $this->getEntityManager()->remove($community);
        $this->getEntityManager()->flush($community);
    }
    
    public function activateFeature(Community $community, string $featureCode)
    {
        $community->getFeatures()->includeFeature($featureCode);
        $this->getEntityManager()->flush([$community]);
    }

    public function deactivateFeature(Community $community, string $featureCode)
    {
        $community->getFeatures()->excludeFeature($featureCode);
        $this->getEntityManager()->flush([$community]);
    }
}