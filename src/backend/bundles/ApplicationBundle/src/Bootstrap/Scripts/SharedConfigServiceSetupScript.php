<?php
namespace Application\Bootstrap\Scripts;

use Application\Bootstrap\Bundle\BundleService;
use Application\Service\SharedConfigService;
use Zend\Expressive\Application;
use Cocur\Chain\Chain;
use Zend\ServiceManager\ServiceManager;

class SharedConfigServiceSetupScript
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var ServiceManager
     */
    private $zendServiceManager;

    public function __construct(Application $app, ServiceManager $zendServiceManager)
    {
        $this->app = $app;
        $this->zendServiceManager = $zendServiceManager;
    }

    public function run() {
        $sharedConfigService = new SharedConfigService();

        $this->mergeBundleConfigs($sharedConfigService);
        $this->mergeProvideConfig($sharedConfigService);

        $this->zendServiceManager->setService(SharedConfigService::class, $sharedConfigService);
    }

    private function mergeBundleConfigs(SharedConfigService $sharedConfigService)
    {
        /** @var BundleService $bundlesService */
        $bundlesService = $this->zendServiceManager->get(BundleService::class);

        foreach ($bundlesService->getBundles() as $bundle) {
            $dir = $bundle->getConfigDir();

            Chain::create(scandir($dir))
                ->filter(function ($input) use ($dir) {
                    return is_file($dir . '/' . $input);
                })
                ->filter(function ($input) use ($dir) {
                    return preg_match('/\.config.php$/', $input);
                })
                ->map(function ($input) use ($dir) {
                    return require $dir . '/' . $input;
                })
                ->reduce(function ($carry, $config) use ($sharedConfigService) {
                    $sharedConfigService->merge($config);
                });
        }
    }

    private function mergeProvideConfig(SharedConfigService $sharedConfigService)
    {
        $paths = $this->zendServiceManager->get('paths');
        $provideConfigFileName = sprintf('%s/provide/provide.config.php', $paths['backend']);

        if(file_exists($provideConfigFileName)) {
            $sharedConfigService->merge(require  $provideConfigFileName);
        }
    }
}