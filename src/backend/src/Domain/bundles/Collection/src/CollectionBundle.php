<?php
namespace Domain\Collection;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Formatter\CollectionTreeFormatter;
use Domain\Collection\Service\CollectionService;
use Application\Frontline\FrontlineBundleInjectable;
use Application\Bundle\GenericBundle;
use DI\Container;
use Application\Frontline\Service\FrontlineService;

class CollectionBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function initFrontline(Container $container, FrontlineService $frontlineService) {
        $collectionService = $container->get(CollectionService::class); /** @var CollectionService $collectionService */
        $currentAccountService = $container->get(CurrentAccountService::class); /** @var CurrentAccountService $currentAccountService */

        $frontlineService::$exporters->addExporter('collections', function() use ($currentAccountService, $collectionService) {
            if ($currentAccountService->isAvailable()) {
                $profileId = $currentAccountService->getCurrentProfile()->getId();

                return [
                    'collections' => (new CollectionTreeFormatter())->format($collectionService->getRootCollections($profileId))
                ];
            } else {
                return [];
            }
        });
    }
}