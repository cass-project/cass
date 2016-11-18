<?php
namespace CASS\Domain\Bundles\Like\Service;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Exception\AttitudeAlreadyExistsException;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;

class LikeProfileService extends LikeService implements LikeableService
{

    public function addLike(LikeableEntity $entity, Attitude $attitude)
    {
        $attitude->setAttitudeType(Attitude::ATTITUDE_TYPE_LIKE);

        if($this->likeRepository->isLikeAttitudeExists($attitude)) {
            throw new AttitudeAlreadyExistsException(sprintf("Сurrent LIKE attitude already exists"));
        }

        $this->likeRepository->createProfileAddLike($attitude);
        $this->profileRepository->saveProfile($entity->increaseLikes());

    }

    public function addDislike(LikeableEntity $entity, Attitude $attitude)
    {
        $attitude->setAttitudeType(Attitude::ATTITUDE_TYPE_DISLIKE);

        if($this->likeRepository->isDislikeAttitudeExists($attitude)) {
            throw new AttitudeAlreadyExistsException(sprintf("Current dislike Attitude already exists"));
        }
        
        $this->likeRepository->createProfileAddLike($attitude);
        $this->profileRepository->saveProfile($entity->increaseDislikes());
    }

}