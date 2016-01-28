<?php
namespace Application\Bootstrap\Scripts;

use Application\Bootstrap\Bundle\BundleService;
use Zend\Expressive\Application;
use Zend\ServiceManager\ServiceManager;

class ContainerSetupScript
{
    public function run(Application $app, ServiceManager $serviceManager) {
        $containerConfig = [];

        /** @var BundleService $bundlesService */
        $bundlesService = $serviceManager->get(BundleService::class);

        foreach($bundlesService->getConfigDirs() as $configDir) {
            $containerConfigFile = sprintf('%s/container.config.php', $configDir);

            if(file_exists($containerConfigFile)) {
                $containerConfig = array_merge_recursive($containerConfig, require $containerConfigFile);
            }
        }

        $serviceManager->configure($containerConfig);
    }
}