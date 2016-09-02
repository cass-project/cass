<?php
namespace CASS\Domain\Community\Feature\Features;

use CASS\Domain\Community\Entity\Community;
use CASS\Domain\Community\Feature\Feature;

abstract class AbstractFeature implements Feature
{
    public function isActivated(Community $community): bool
    {
        return $community->getFeatures()->hasFeature($this->getCode());
    }
}