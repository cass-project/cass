<?php
namespace Domain\Collection;

use Domain\Collection\Frontline\CurrentProfileCollectionsScript;
use Application\Frontline\FrontlineBundleInjectable;
use Application\Bundle\GenericBundle;

class CollectionBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array {
        return [
            'collections' => CurrentProfileCollectionsScript::class
        ];
    }
}