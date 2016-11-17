<?php
namespace CASS\Domain\Bundles\Like\Service;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;

class LikeProfileService extends LikeService implements LikeableService
{

    public function addLike(LikeableEntity $entity, Attitude $attitude)
    {

        // save log
        if($this->getAttitudeByEntity($attitude)) {
            print_r("its shit we already have attitude");
            die();
        }

        $this->likeRepository->createProfileAddLike($attitude);
        // increase entity
        // save Entity

        print_r("chot to rabotaet");
        die();
    }

    public function removeLike(LikeableEntity $entity)
    {
        $this->likeRepository->removeAttitude();
    }

    public function getAttitudeByEntity(Attitude $attitude): Attitude
    {
        return $this->likeRepository->findOneBy([
            'attitudeOwnerType' => $attitude->getAttitudeOwnerType(),
            'profileId' => $attitude->getProfileId(),
            'ipAddress' => $attitude->getIpAddress(),
            'attitudeType' => $attitude->getAttitudeType(),
            'resourceId' => $attitude->getResourceId(),
            'resourceType' => $attitude->getResourceType(),
            //            'id' => $attitude->isPersisted() !== true ? null : $attitude->getId(),
            //            'created' => $attitude->getCreated(),
        ]);
    }

}