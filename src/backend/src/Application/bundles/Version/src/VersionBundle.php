<?php
namespace Application\Version;

use Application\Bundle\GenericBundle;
use Application\Frontline\FrontlineBundleInjectable;
use Application\Version\Frontline\VersionFrontlineScript;

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