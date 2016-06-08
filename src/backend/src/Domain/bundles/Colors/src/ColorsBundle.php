<?php
namespace Domain\Colors;

use Application\Bundle\GenericBundle;
use Application\Frontline\FrontlineBundleInjectable;
use Domain\Colors\Frontline\ConfigColorsFrontlineScript;

final class ColorsBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir() {
        return __DIR__;
    }

    public function getFrontlineScripts(): array {
        return [
            ConfigColorsFrontlineScript::class
        ];
    }
}