<?php
namespace CASS\Domain\Bundles\Like\Service;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Repository\LikeRepository\LikeRepository;
use CASS\Domain\Bundles\Profile\Repository\ProfileRepository;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;

abstract class LikeService
{
    protected $likeRepository;
    protected $profileRepository;

    public function __construct(
        LikeRepository $likeRepository,
        ProfileRepository $profileRepository
    ){
        $this->likeRepository = $likeRepository;
        $this->profileRepository = $profileRepository;
    }

    abstract public function addLike(LikeableEntity $entity, Attitude $attitude): Attitude;

    abstract public function addDislike(LikeableEntity $entity, Attitude $attitude): Attitude;

    public function removeLike(LikeableEntity $entity, Attitude $attitude)
    {

        if(! $attitude->isPersisted()) {
            $attitude = $this->likeRepository->getLikeAttitude($attitude);
        }

        $this->likeRepository->removeAttitude($attitude);
        $this->profileRepository->saveProfile($entity->decreaseLikes());

    }

    public function removeDislike(LikeableEntity $entity, Attitude $attitude)
    {
        if(! $attitude->isPersisted()) {
            $attitude = $this->likeRepository->getDisLikeAttitude($attitude);
        }

        $this->likeRepository->removeAttitude($attitude);
        $this->profileRepository->saveProfile($entity->decreaseDislikes());
    }
}