<?php

namespace CASS\Domain\Bundles\Like\Service;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;

interface LikeableService
{
    public function addLike(LikeableEntity $entity, Attitude $attitude);
    public function removeLike(LikeableEntity $entity);
    public function getAttitudeByEntity(Attitude $attitude): Attitude;

    //    public function addDislike(LikeableEntity $entity, Attitude $attitude);


    //abstract public function removeDislike(LikeableEntity $entity);
}