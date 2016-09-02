<?php
namespace CASS\Domain\Community;

use CASS\Application\Bundle\GenericBundle;
use CASS\Application\Bundles\Frontline\FrontlineBundleInjectable;
use CASS\Domain\Community\Scripts\FeaturesListFrontlineScript;

final class CommunityBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array
    {
        return [
            FeaturesListFrontlineScript::class
        ];
    }
}