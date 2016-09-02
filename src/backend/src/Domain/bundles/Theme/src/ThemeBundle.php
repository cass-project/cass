<?php
namespace CASS\Domain\Bundles\Theme;

use CASS\Application\Bundles\Frontline\FrontlineBundleInjectable;
use CASS\Application\Bundle\GenericBundle;
use CASS\Domain\Bundles\Theme\Frontline\ThemeScript;

class ThemeBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array
    {
        return [
            ThemeScript::class
        ];
    }
}