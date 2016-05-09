<?php
namespace Domain\Theme;

use Application\Frontline\FrontlineBundleInjectable;
use Application\Bundle\GenericBundle;
use Domain\Theme\Frontline\ThemeScript;

class ThemeBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array
    {
        return [
            'themes' => ThemeScript::class
        ];
    }
}