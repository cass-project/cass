<?php

namespace CASS\Domain\Bundles\Like\Repository\LikeRepository;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use Doctrine\ORM\EntityRepository;

class LikeRepository extends EntityRepository
{
    // Profile
    public function createProfileAddLike(Attitude $attitude){
        $em = $this->getEntityManager();
        $em->persist($attitude);
        $em->flush();
    }

    public function removeAttitude(Attitude $attitude)
    {
        $em = $this->getEntityManager();
        if($attitude->isPersisted()){
            $em->remove($attitude);
            $em->flush();
        }
    }

    // Collection
    // Community
    // Theme

}