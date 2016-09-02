<?php
namespace CASS\Domain\Bundles\Post;

use CASS\Application\Bundle\GenericBundle;
use CASS\Application\Bundles\Frontline\FrontlineBundleInjectable;
use CASS\Domain\Bundles\Post\Frontline\PostTypeFrontlineScript;

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