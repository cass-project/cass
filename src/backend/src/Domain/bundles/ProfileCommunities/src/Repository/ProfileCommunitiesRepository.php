<?php
namespace Domain\ProfileCommunities\Repository;

use Application\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Domain\Community\Entity\Community;
use Domain\Profile\Entity\Profile;
use Domain\ProfileCommunities\Entity\ProfileCommunityEQ;
use Domain\ProfileCommunities\Exception\BookmarkNotFoundException;

class ProfileCommunitiesRepository extends EntityRepository
{
    public function joinToCommunity(int $profileId, int $communityId): ProfileCommunityEQ {
        $em = $this->getEntityManager();

        $profile = $em->getReference(Profile::class, $profileId);
        $community = $em->getReference(Community::class, $communityId);

        if(! (($profile instanceof Profile) && ($community instanceof Community))) {
            throw new EntityNotFoundException('Profile or/and community not found');
        }

        $entity = new ProfileCommunityEQ($profile, $community);

        $em->persist($entity);
        $em->flush($entity);

        return $entity;
    }

    public function leaveCommunity(int $profileId, int $communityId): ProfileCommunityEQ {
        if($this->hasBookmark($profileId, $communityId)) {
            $bookmark = $this->getBookmark($profileId, $communityId);

            $this->getEntityManager()->remove($bookmark);
            $this->getEntityManager()->flush($bookmark);
        }
    }

    public function getEntitiesByProfile(int $profileId): array {
        return $this->findBy([
            'profile' => $profileId
        ]);
    }
    
    public function getBookmark(int $profileId, int $communityId): ProfileCommunityEQ {
        $entity = $this->findOneBy([
            'profile' => $profileId,
            'community' => $communityId
        ]);
        
        if($entity === null) {
            throw new BookmarkNotFoundException(sprintf('Bookmark with `profileId:%d/communityId:%d` not found', $profileId, $communityId));
        }

        return $entity;
    }
    
    public function hasBookmark(int $profileId, int $communityId): bool {
        return $this->findOneBy([
            'profile' => $profileId,
            'community' => $communityId
        ]) !== null;
    }
}