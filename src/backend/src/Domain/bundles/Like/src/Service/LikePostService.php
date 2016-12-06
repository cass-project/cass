<?php

namespace CASS\Domain\Bundles\Like\Service;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Exception\AttitudeAlreadyExistsException;
use CASS\Domain\Bundles\Like\Repository\LikeRepository\LikeRepository;
use CASS\Domain\Bundles\Post\Repository\PostRepository;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;

class LikePostService extends LikeService
{
    protected $postRepository;

    public function __construct(LikeRepository $likeRepository, PostRepository $postRepository)
    {
        parent::__construct($likeRepository);
        $this->postRepository = $postRepository;
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
        $this->postRepository->savePost($entity->increaseLikes());

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
        $this->postRepository->savePost($entity->increaseDislikes());

        return $attitude;
    }

}