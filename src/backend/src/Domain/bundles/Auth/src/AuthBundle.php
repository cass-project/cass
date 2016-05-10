<?php
namespace Domain\Auth;

use Domain\Auth\Frontline\AuthTokenScript;
use Application\Frontline\FrontlineBundleInjectable;
use Application\Bundle\GenericBundle;

class AuthBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array {
        return [
            'auth' => AuthTokenScript::class
        ];
    }
}