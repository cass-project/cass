<?php

namespace Domain\bundles\Like\src\Service;


use CASS\Domain\Bundles\Like\Service\LikeService;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;

class LikeProfileService extends LikeService
{
    public function addLike(LikeableEntity $profile){
        $this->likeProfileRepository->addLike($profile);


        return $this->profileRepository->saveProfile($profile);
    }

    public function removeLike(LikeableEntity $profile){
        // TODO: Implement removeLike() method.
    }

    public function addDislike(LikeableEntity $profile){
        // TODO: Implement addDislike() method.
    }

    public function removeDislike(LikeableEntity $profile){
        // TODO: Implement removeDislike() method.
    }


}