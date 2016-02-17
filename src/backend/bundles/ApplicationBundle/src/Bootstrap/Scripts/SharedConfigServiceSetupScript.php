<?php
namespace Application\Bootstrap\Scripts;

use Application\Bootstrap\Bundle\BundleService;
use Application\Service\SharedConfigService;
use Zend\Expressive\Application;
use Cocur\Chain\Chain;
use Zend\ServiceManager\ServiceManager;

class SharedConfigServiceSetupScript
{
    public function run(Application $app, ServiceManager $zendServiceManager) {
        /** @var BundleService $bundlesService */
        $bundlesService = $zendServiceManager->get(BundleService::class);
        $sharedConfigService = new SharedConfigService();

        foreach($bundlesService->getBundles() as $bundle) {
            $dir = $bundle->getConfigDir();

            Chain::create(scandir($dir))
                ->filter(function($input) use ($dir) {
                    return is_file($dir.'/'.$input);
                })
                ->filter(function($input) use ($dir) {
                    return preg_match('/\.config.php$/', $input);
                })
                ->map(function($input) use ($dir) {
                    return require $dir.'/'.$input;
                })
                ->reduce(function($carry, $config) use ($sharedConfigService) {
                    $sharedConfigService->merge($config);
                })
            ;
        }

        $zendServiceManager->setService(SharedConfigService::class, $sharedConfigService);
    }
}