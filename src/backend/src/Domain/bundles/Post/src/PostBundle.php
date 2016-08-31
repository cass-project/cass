<?php
namespace Domain\Post;

use CASS\Application\Bundle\GenericBundle;
use CASS\Application\Bundles\Frontline\FrontlineBundleInjectable;
use Domain\Post\Frontline\PostTypeFrontlineScript;

class PostBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array
    {
        return [
            PostTypeFrontlineScript::class
        ];
    }
}