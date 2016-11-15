<?php

namespace CASS\Domain\Bundles\Like\Service;

use CASS\Domain\Bundles\Profile\Repository\ProfileRepository;
use Domain\bundles\Like\src\Repository\LikeRepository\LikeProfileRepository;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;

abstract class LikeService
{
    protected $likeProfileRepository;
    protected $likeRepository;

    public function __construct(ProfileRepository $profileRepository,
                                LikeProfileRepository $likeProfileRepository )
    {
        $this->profileRepository = $profileRepository;
        $this->likeProfileRepository = $likeProfileRepository;
    }

    abstract public function addLike(LikeableEntity $entity);
    abstract public function removeLike(LikeableEntity $entity);
    abstract public function addDislike(LikeableEntity $entity);
    abstract public function removeDislike(LikeableEntity $entity);
}