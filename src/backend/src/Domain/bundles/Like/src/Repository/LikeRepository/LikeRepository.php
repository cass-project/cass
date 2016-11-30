<?php

namespace CASS\Domain\Bundles\Like\Repository\LikeRepository;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Exception\AttitudeNotFoundException;
use Doctrine\ORM\EntityRepository;

class LikeRepository extends EntityRepository
{
    // Profile
    public function saveAttitude(Attitude $attitude): Attitude
    {
        $em = $this->getEntityManager();
        $em->persist($attitude);
        $em->flush();
        return $attitude;
    }

    public function removeAttitude(Attitude $attitude)
    {
        $em = $this->getEntityManager();
        if($attitude->isPersisted()) {
            $em->remove($attitude);
            $em->flush();
        }
    }

    public function isAttitudeExists(Attitude $attitude): bool
    {
        return null !== $this->findOneBy([
            'attitudeOwnerType' => $attitude->getAttitudeOwnerType(),
            'profileId' => $attitude->getProfileId(),
            'ipAddress' => $attitude->getIpAddress(),
            'resourceId' => $attitude->getResourceId(),
            'resourceType' => $attitude->getResourceType(),
        ]);
    }

    public function getAttitude(Attitude $attitude): Attitude
    {
        $bdAttitude = $this->findOneBy([
            'attitudeOwnerType' => $attitude->getAttitudeOwnerType(),
            'profileId' => $attitude->getProfileId(),
            'ipAddress' => $attitude->getIpAddress(),
            'resourceId' => $attitude->getResourceId(),
            'resourceType' => $attitude->getResourceType(),
            //            'id' => $attitude->isPersisted() !== true ? null : $attitude->getId(),
            //            'created' => $attitude->getCreated(),
        ]);

        if(null === $bdAttitude) {
            throw new AttitudeNotFoundException();
        }

        return $bdAttitude;
    }

    public function getLikeAttitude(Attitude $attitude): Attitude
    {
        $bdAttitude = $this->findOneBy([
            'attitudeOwnerType' => $attitude->getAttitudeOwnerType(),
            'profileId' => $attitude->getProfileId(),
            'ipAddress' => $attitude->getIpAddress(),
            'resourceId' => $attitude->getResourceId(),
            'resourceType' => $attitude->getResourceType(),
            'attitudeType' => Attitude::ATTITUDE_TYPE_LIKE,
        ]);

        if(null === $bdAttitude) {
            throw new AttitudeNotFoundException();
        }

        return $bdAttitude;
    }

    public function getDisLikeAttitude(Attitude $attitude): Attitude
    {
        $bdAttitude = $this->findOneBy([
            'attitudeOwnerType' => $attitude->getAttitudeOwnerType(),
            'profileId' => $attitude->getProfileId(),
            'ipAddress' => $attitude->getIpAddress(),
            'resourceId' => $attitude->getResourceId(),
            'resourceType' => $attitude->getResourceType(),
            'attitudeType' => Attitude::ATTITUDE_TYPE_DISLIKE,
        ]);

        if(null === $bdAttitude) {
            throw new AttitudeNotFoundException();
        }

        return $bdAttitude;
    }

    // Collection
    // Community
    // Theme

}