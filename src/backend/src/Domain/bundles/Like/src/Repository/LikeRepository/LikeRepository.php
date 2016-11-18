<?php

namespace CASS\Domain\Bundles\Like\Repository\LikeRepository;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use Doctrine\ORM\EntityRepository;

class LikeRepository extends EntityRepository
{
    // Profile
    public function createProfileAddLike(Attitude $attitude){
        $em = $this->getEntityManager();
        $em->persist($attitude);
        $em->flush();
    }

    public function removeAttitude(Attitude $attitude)
    {
        $em = $this->getEntityManager();
        if($attitude->isPersisted()){
            $em->remove($attitude);
            $em->flush();
        }
    }

    public function isLikeAttitudeExists(Attitude $attitude): bool
    {
        return null !== $this->findOneBy([
            'attitudeOwnerType' => $attitude->getAttitudeOwnerType(),
            'profileId' => $attitude->getProfileId(),
            'ipAddress' => $attitude->getIpAddress(),
            'attitudeType' => Attitude::ATTITUDE_TYPE_LIKE,
            'resourceId' => $attitude->getResourceId(),
            'resourceType' => $attitude->getResourceType(),
            //            'id' => $attitude->isPersisted() !== true ? null : $attitude->getId(),
            //            'created' => $attitude->getCreated(),
        ]);
    }

    public function isDislikeAttitudeExists(Attitude $attitude): bool
    {
        return null !== $this->findOneBy([
            'attitudeOwnerType' => $attitude->getAttitudeOwnerType(),
            'profileId' => $attitude->getProfileId(),
            'ipAddress' => $attitude->getIpAddress(),
            'attitudeType' => Attitude::ATTITUDE_TYPE_DISLIKE,
            'resourceId' => $attitude->getResourceId(),
            'resourceType' => $attitude->getResourceType(),
            //            'id' => $attitude->isPersisted() !== true ? null : $attitude->getId(),
            //            'created' => $attitude->getCreated(),
        ]);
    }


    // Collection
    // Community
    // Theme

}