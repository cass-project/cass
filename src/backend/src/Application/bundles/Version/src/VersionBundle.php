<?php
namespace CASS\Application\Bundles\Version;

use CASS\Application\Bundle\GenericBundle;
use CASS\Application\Bundles\Frontline\FrontlineBundleInjectable;
use CASS\Application\Bundles\Version\Frontline\VersionFrontlineScript;

final class VersionBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array
    {
        return [
            VersionFrontlineScript::class
        ];
    }
}