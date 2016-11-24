<?php
namespace CASS\Domain\Bundles\Like\Service;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Exception\AttitudeAlreadyExistsException;
use CASS\Domain\Bundles\Like\Repository\LikeRepository\LikeRepository;
use CASS\Domain\Bundles\Profile\Repository\ProfileRepository;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;

class LikeProfileService extends LikeService
{
    protected $profileRepository;

    public function __construct(LikeRepository $likeRepository, ProfileRepository $profileRepository)
    {
        parent::__construct($likeRepository);
        $this->profileRepository = $profileRepository;
    }

    public function addLike(LikeableEntity $entity, Attitude $attitude): Attitude
    {
        $attitude->setAttitudeType(Attitude::ATTITUDE_TYPE_LIKE);

        if($this->likeRepository->isAttitudeExists($attitude)) {
            $existAttitude = $this->likeRepository->getAttitude($attitude);
            switch($existAttitude->getAttitudeType()) {
                case Attitude::ATTITUDE_TYPE_LIKE:
                    throw new AttitudeAlreadyExistsException(sprintf("Сurrent LIKE attitude already exists"));
                    break;
                case Attitude::ATTITUDE_TYPE_DISLIKE:
                    $this->likeRepository->removeAttitude($existAttitude);
                    $entity->decreaseDislikes();
                    break;
            }
        }

        $attitude = $this->likeRepository->saveAttitude($attitude);
        $this->profileRepository->saveProfile($entity->increaseLikes());

        return $attitude;
    }

    public function addDislike(LikeableEntity $entity, Attitude $attitude): Attitude
    {
        $attitude->setAttitudeType(Attitude::ATTITUDE_TYPE_DISLIKE);

        if($this->likeRepository->isAttitudeExists($attitude)) {
            $existsAttitude = $this->likeRepository->getAttitude($attitude);
            switch($existsAttitude->getAttitudeType()) {
                case Attitude::ATTITUDE_TYPE_DISLIKE:
                    throw new AttitudeAlreadyExistsException(sprintf("Current dislike Attitude already exists"));
                    break;

                case Attitude::ATTITUDE_TYPE_LIKE:
                    $this->likeRepository->removeAttitude($existsAttitude);
                    $entity->decreaseLikes();
                    break;
            }
        }

        $attitude = $this->likeRepository->saveAttitude($attitude);
        $this->profileRepository->saveProfile($entity->increaseDislikes());

        return $attitude;
    }

    public function removeLike(LikeableEntity $entity, Attitude $attitude)
    {
        parent::removeLike($entity, $attitude);
        $this->profileRepository->saveProfile($entity->decreaseLikes());
    }

    public function removeDislike(LikeableEntity $entity, Attitude $attitude)
    {
        parent::removeDislike($entity, $attitude);
        $this->profileRepository->saveProfile($entity->decreaseDislikes());
    }

}