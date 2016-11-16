<?php
namespace CASS\Domain\Bundles\Like\Repository\LikeRepository;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Profile\Entity\Profile;

class LikeProfileRepository extends LikeRepository
{
    public function addLike(Attitude $attitude){


        print_r($attitude);
        die();
        /** @var Profile $entity */
        $em = $this->getEntityManager();


        // проверяем в базе
        // сохраняем в базу
        $em->persist($attitude);
        $em->flush();

    }

}