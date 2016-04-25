<?php
namespace Collection;

use Auth\Service\CurrentAccountService;
use Collection\Formatter\CollectionTreeFormatter;
use Collection\Service\CollectionService;
use Common\Bootstrap\Bundle\FrontlineBundleInjectable;
use Common\Bootstrap\Bundle\GenericBundle;
use DI\Container;
use Frontline\Service\FrontlineService;

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