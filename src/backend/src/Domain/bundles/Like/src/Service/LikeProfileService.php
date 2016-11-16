<?php
namespace CASS\Domain\Bundles\Like\Service;


use CASS\Domain\Bundles\Like\Entity\Attitude;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;

class LikeProfileService extends LikeService
{
    
    

    public function addLike(LikeableEntity $entity, Attitude $attitude)
    {

        print_r("chot to rabotaet");
//        $this->likeProfileRepository->addLike($attitude);
    }

}