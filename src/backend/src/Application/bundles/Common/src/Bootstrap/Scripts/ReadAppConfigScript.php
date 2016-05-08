<?php
namespace Application\Common\Bootstrap\Scripts;

use Application\Common\Bootstrap\Bundle\Bundle;
use Application\Common\Service\SharedConfigService;
use Cocur\Chain\Chain;

class ReadAppConfigScript
{
    /** @var string */
    private $backendPath;

    public function __construct(string $backendPath)
    {
        $this->backendPath = $backendPath;
    }

    public function __invoke(SharedConfigService $sharedConfigService, array $bundles)
    {
        $this->mergeBundleConfigs($sharedConfigService, $bundles);
        $this->mergeProvideConfig($sharedConfigService);
    }

    private function mergeBundleConfigs(SharedConfigService $sharedConfigService, array $bundles)
    {
        /** @var Bundle[] $bundles */
        foreach ($bundles as $bundle) {
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
        $provideConfigFileName = sprintf('%s/provide/provide.config.php', $this->backendPath);

        if(file_exists($provideConfigFileName)) {
            $provideConfig = require $provideConfigFileName;

            $sharedConfigService->merge($provideConfig);
        }
    }
}