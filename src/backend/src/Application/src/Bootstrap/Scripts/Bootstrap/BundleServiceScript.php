<?php
namespace CASS\Application\Bootstrap\Scripts\Bootstrap;

use CASS\Application\Bootstrap\AppBuilder;
use CASS\Application\Bootstrap\Scripts\BootstrapScript;
use CASS\Application\Bundle\Bundle;
use CASS\Application\Service\BundleService;
use Cocur\Chain\Chain;

class BundleServiceScript implements BootstrapScript
{
    public function __invoke(AppBuilder $appBuilder) {
        $bundleService = new BundleService();

        foreach ($appBuilder->getRootBundles() as $bundle) {
            $this->scanBundle($bundle, $bundleService);
        }

        $appBuilder->setBundleService($bundleService);
    }

    private function scanBundle(Bundle $bundle, BundleService $bundleService) {
        $bundleService->addBundle($bundle);

        if($bundle->hasBundles()) {
            $rootNamespace = $bundle->getNamespace();
            $rootDir = $bundle->getBundlesDir();

            $bundles = Chain::create(scandir($bundle->getBundlesDir()))
                ->filter(function(string $dir) use ($rootDir) {
                    return $dir != '.' && $dir != '..' && is_dir($rootDir.'/'.$dir);
                })
                ->map(function(string $dir) use ($rootNamespace) {
                    $bundleClassName = "{$rootNamespace}\\{$dir}\\{$dir}Bundle";

                    if (!class_exists($bundleClassName)) {
                        $bundleClassName =  "{$rootNamespace}\\Bundles\\{$dir}\\{$dir}Bundle";

                        if (!class_exists($bundleClassName)) {
                            throw new \Exception(sprintf('No Bundle available for bundle `%s`', $bundleClassName));
                        }
                    }

                    if (!is_subclass_of($bundleClassName, Bundle::class)) {
                        throw new \Exception(sprintf('Bundle `%s` should implements interface %s', $bundleClassName, Bundle::class));
                    }

                    return new $bundleClassName();
                })
            ->array;

            foreach($bundles as $bundle) {
                $this->scanBundle($bundle, $bundleService);
            }
        }
    }
}