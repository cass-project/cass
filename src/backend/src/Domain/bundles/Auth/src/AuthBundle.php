<?php
namespace Domain\Auth;

use Domain\Auth\Frontline\AuthTokenScript;
use CASS\Application\Frontline\FrontlineBundleInjectable;
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