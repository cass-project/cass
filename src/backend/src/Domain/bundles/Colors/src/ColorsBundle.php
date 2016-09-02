<?php
namespace CASS\Domain\Colors;

use CASS\Application\Bundle\GenericBundle;
use CASS\Application\Bundles\Frontline\FrontlineBundleInjectable;
use CASS\Domain\Colors\Frontline\ConfigColorsFrontlineScript;

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