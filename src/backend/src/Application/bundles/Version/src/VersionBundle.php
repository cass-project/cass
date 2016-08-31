<?php
namespace CASS\Application\Version;

use CASS\Application\Bundle\GenericBundle;
use CASS\Application\Frontline\FrontlineBundleInjectable;
use CASS\Application\Version\Frontline\VersionFrontlineScript;

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