<?php
namespace Domain\Community\Feature\Features;

use Domain\Community\Entity\Community;
use Domain\Community\Feature\Feature;

abstract class AbstractFeature implements Feature
{
    public function isActivated(Community $community): bool
    {
        return $community->getFeatures()->hasFeature($this->getCode());
    }
}