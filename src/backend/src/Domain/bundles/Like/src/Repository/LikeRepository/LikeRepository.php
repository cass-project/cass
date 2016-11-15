<?php

namespace Domain\bundles\Like\src\Repository\LikeRepository;

use Doctrine\ORM\EntityRepository;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;

abstract class LikeRepository extends EntityRepository
{
    abstract function addLike(LikeableEntity $entity);

    abstract function removeLike(LikeableEntity $entity);

    abstract function addDislike(LikeableEntity $entity);

    abstract function removeDislike(LikeableEntity $entity);
}