<?php
namespace CASS\Domain\Bundles\Account;

use CASS\Application\Bundle\GenericBundle;
use CASS\Application\Bundles\Frontline\FrontlineBundleInjectable;
use CASS\Domain\Bundles\Account\Frontline\ConfigAccountFrontlineScript;

class AccountBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array
    {
        return [
            ConfigAccountFrontlineScript::class
        ];
    }
}