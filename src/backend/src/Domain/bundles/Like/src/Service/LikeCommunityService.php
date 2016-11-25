<?php

namespace CASS\Domain\Bundles\Like\Service;

use CASS\Domain\Bundles\Community\Repository\CommunityRepository;
use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Exception\AttitudeAlreadyExistsException;
use CASS\Domain\Bundles\Like\Repository\LikeRepository\LikeRepository;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;

class LikeCommunityService extends LikeService
{
    protected $communityRepository;

    public function __construct(
        LikeRepository $likeRepository,
        CommunityRepository $communityRepository
    )
    {
        parent::__construct($likeRepository);
        $this->communityRepository = $communityRepository;
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

        $this->communityRepository->saveCommunity($entity->increaseLikes());

        return $attitude;

    }

    public function addDislike(LikeableEntity $entity, Attitude $attitude): Attitude
    {
        $attitude->setAttitudeType(Attitude::ATTITUDE_TYPE_DISLIKE);

        if($this->likeRepository->isAttitudeExists($attitude)) {
            $existAttitude = $this->likeRepository->getAttitude($attitude);

            switch($existAttitude->getAttitudeType()) {
                case Attitude::ATTITUDE_TYPE_LIKE:
                    $this->likeRepository->removeAttitude($existAttitude);
                    $entity->decreaseLikes();
                    break;
                case Attitude::ATTITUDE_TYPE_DISLIKE:
                    throw new AttitudeAlreadyExistsException(sprintf("Сurrent LIKE attitude already exists"));
                    break;
            }
        }

        $attitude = $this->likeRepository->saveAttitude($attitude);

        $this->communityRepository->saveCommunity($entity->increaseDislikes());

        return $attitude;
    }

    public function removeLike(LikeableEntity $entity, Attitude $attitude)
    {
        parent::removeLike($entity, $attitude);
        $this->communityRepository->saveCommunity($entity->decreaseLikes());
    }

    public function removeDislike(LikeableEntity $entity, Attitude $attitude)
    {
        parent::removeDislike($entity, $attitude);
        $this->communityRepository->saveCommunity($entity->decreaseDislikes());
    }

}