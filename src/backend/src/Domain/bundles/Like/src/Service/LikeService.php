<?php
namespace CASS\Domain\Bundles\Like\Service;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Repository\LikeRepository\LikeRepository;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;

abstract class LikeService
{
    protected $likeRepository;

    public function __construct(
        LikeRepository $likeRepository
    ){
        $this->likeRepository = $likeRepository;
    }

    abstract public function addLike(LikeableEntity $entity, Attitude $attitude): Attitude;

    abstract public function addDislike(LikeableEntity $entity, Attitude $attitude): Attitude;

    public function removeLike(LikeableEntity $entity, Attitude $attitude)
    {

        if(! $attitude->isPersisted()) {
            $attitude = $this->likeRepository->getLikeAttitude($attitude);
        }

        $this->likeRepository->removeAttitude($attitude);
    }

    public function removeDislike(LikeableEntity $entity, Attitude $attitude)
    {
        if(! $attitude->isPersisted()) {
            $attitude = $this->likeRepository->getDisLikeAttitude($attitude);
        }

        $this->likeRepository->removeAttitude($attitude);
    }

    public function getAttitude(Attitude $attitude): Attitude
    {
        return $this->likeRepository->getAttitude($attitude);
    }
}