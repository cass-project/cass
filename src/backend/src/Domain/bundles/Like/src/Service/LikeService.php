<?php

namespace CASS\Domain\Bundles\Like\Service;

abstract class LikeService
{
    

    public function __construct()
    {

    }

    abstract public function addLike();
    abstract public function removeLike();
    abstract public function addDislike();
    abstract public function removeDislike();
}