<?php
namespace CASS\Domain\Bundles\Auth;

use CASS\Domain\Bundles\Auth\Frontline\AuthTokenScript;
use CASS\Application\Bundles\Frontline\FrontlineBundleInjectable;
use CASS\Application\Bundle\GenericBundle;

class AuthBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array {
        return [
            AuthTokenScript::class
        ];
    }
}