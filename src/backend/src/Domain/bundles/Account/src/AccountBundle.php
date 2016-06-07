<?php
namespace Domain\Account;

use Application\Bundle\GenericBundle;
use Application\Frontline\FrontlineBundleInjectable;
use Domain\Account\Frontline\ConfigAccountFrontlineScript;

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