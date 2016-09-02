<?php
namespace CASS\Domain\Profile;

use CASS\Application\Bundle\GenericBundle;
use CASS\Application\Bundles\Frontline\FrontlineBundleInjectable;
use CASS\Domain\Profile\Frontline\ConfigProfileFrontlineScript;

class ProfileBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array
    {
        return [
            ConfigProfileFrontlineScript::class
        ];
    }
}