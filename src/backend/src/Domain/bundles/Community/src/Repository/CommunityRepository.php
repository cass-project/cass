<?php
namespace Domain\Community\Repository;

use Domain\Community\Entity\Community;
use Doctrine\ORM\EntityRepository;
use Domain\Community\Exception\CommunityNotFoundException;

class CommunityRepository extends EntityRepository
{
    public function createCommunity(Community $community): Community {
        $this->getEntityManager()->persist($community);
        $this->getEntityManager()->flush($community);

        return $community;
    }

    public function saveCommunity(Community $community): Community {
        $this->getEntityManager()->flush($community);

        return $community;
    }

    public function getCommunityById(int $communityId): Community {
        $entity = $this->find($communityId);

        if($entity === null) {
            throw new CommunityNotFoundException(sprintf('Community with ID `%s` not found', $entity));
        }

        return $entity;
    }

    public function deleteCommunity(Community $community) {
        throw new \DomainException(sprintf('There is no way you can delete the community. Check out project documentations: %s', '/docs/stories/community/00-community-no-delete.md'));
    }

    public function clearImage(Community $community) {
        $community->clearImage();
        $this->getEntityManager()->flush($community);
    }

    public function setImage(Community $community, Community\CommunityImage $communityImage) {
        $community->setImage($communityImage);
        $this->getEntityManager()->flush($community);
    }

    public function linkCollection(int $communityId, int $collectionId): Community {
        $community = $this->getCommunityById($communityId);
        $collections = $community->getCollections();

        if(! $collections->hasCollection($collectionId)) {
            $community->getCollections()->attachChild($collectionId);
        }

        return $this->saveCommunity($community);
    }

    public function unlinkCollection(int $communityId, int $collectionId): Community {
        $community = $this->getCommunityById($communityId);
        $collections = $community->getCollections();

        if($collections->hasCollection($collectionId)) {
            $collections->detachChild($collectionId);
        }

        return $this->saveCommunity($community);
    }
}