<?php
namespace Domain\bundles\Like\src\Repository\LikeRepository;

use CASS\Domain\Bundles\Profile\Entity\Profile;
use Domain\bundles\Like\src\Entity\Attitude;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;

class LikeProfileRepository extends LikeRepository
{
    function addLike(LikeableEntity $entity){

        /** @var Profile $entity */
        $em = $this->getEntityManager();

        $attitude = new Attitude();
        $attitude
            ->setAttitudeType(Attitude::ATTITUDE_TYPE_LIKE)
            ->setResourceId($entity->getId())
        ;

        // проверяем в базе
        // сохраняем в базу
        $em->persist($attitude);
        $em->flush();

    }

    function removeLike(LikeableEntity $entity){
        // TODO: Implement removeLike() method.
    }

    function addDislike(LikeableEntity $entity){
        // TODO: Implement addDislike() method.
    }

    function removeDislike(LikeableEntity $entity){
        // TODO: Implement removeDislike() method.
    }

}