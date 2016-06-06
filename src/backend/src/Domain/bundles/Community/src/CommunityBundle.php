<?php
namespace Domain\Community;

use Application\Bundle\GenericBundle;
use Application\Frontline\FrontlineBundleInjectable;
use Domain\Community\Frontline\ConfigCommunityFrontlineScript;

final class CommunityBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array
    {
        return [
            ConfigCommunityFrontlineScript::class
        ];
    }
}