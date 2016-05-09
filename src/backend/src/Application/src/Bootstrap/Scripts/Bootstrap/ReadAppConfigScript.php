<?php
namespace Application\Bootstrap\Scripts\Bootstrap;

use Application\Bootstrap\AppBuilder;
use Application\Bootstrap\Scripts\BootstrapScript;
use Application\Bundle\Bundle;
use Application\Service\ConfigService;
use Cocur\Chain\Chain;

class ReadAppConfigScript implements BootstrapScript
{
    public function __invoke(AppBuilder $appBuilder) {
        $configService = new ConfigService();

        $this->mergeBundleConfigs($configService, $appBuilder->getBundleService()->getBundles());
        $this->mergeProvideConfig($configService, $configService->get('php-di')['paths']['backend']);

        $appBuilder->setConfigService($configService);
    }

    private function mergeBundleConfigs(ConfigService $configService, array $bundles)
    {
        array_walk($bundles, function(Bundle $bundle) use ($configService) {
            $dir = $bundle->getConfigDir();

            if(is_dir($dir)) {
                Chain::create(scandir($dir))
                    ->filter(function ($input) use ($dir) {
                        return is_file($dir . '/' . $input) && preg_match('/\.config.php$/', $input);
                    })
                    ->map(function ($input) use ($dir) {
                        return require $dir . '/' . $input;
                    })
                    ->map(function (array $config) use ($configService) {
                        $configService->merge($config);

                        return null;
                    });
            }
        });
    }

    private function mergeProvideConfig(ConfigService $configService, string $backendPath)
    {
        $provideConfigFileName = sprintf('%s/provide/provide.config.php', $backendPath);

        if(file_exists($provideConfigFileName)) {
            $provideConfig = require $provideConfigFileName;

            $configService->merge($provideConfig);
        }
    }
}