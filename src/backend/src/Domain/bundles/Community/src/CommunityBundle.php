<?php
namespace Domain\Community;

use CASS\Application\Bundle\GenericBundle;
use CASS\Application\Frontline\FrontlineBundleInjectable;
use Domain\Community\Scripts\FeaturesListFrontlineScript;

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