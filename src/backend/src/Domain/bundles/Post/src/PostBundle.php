<?php
namespace Domain\Post;

use Application\Bundle\GenericBundle;
use Application\Frontline\FrontlineBundleInjectable;
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