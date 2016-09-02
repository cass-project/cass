<?php
namespace CASS\Domain\Bundles\Community\Feature\Features;

use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Community\Feature\Feature;

abstract class AbstractFeature implements Feature
{
    public function isActivated(Community $community): bool
    {
        return $community->getFeatures()->hasFeature($this->getCode());
    }
}