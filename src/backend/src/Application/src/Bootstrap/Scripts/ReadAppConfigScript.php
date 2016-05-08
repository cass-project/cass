<?php
namespace Application\Bootstrap\Scripts;

use Application\Service\ConfigService;
use Cocur\Chain\Chain;

class ReadAppConfigScript
{
    /** @var string */
    private $backendPath;

    public function __construct(string $backendPath)
    {
        $this->backendPath = $backendPath;
    }

    public function __invoke(ConfigService $configService, array $bundles)
    {
        $this->mergeBundleConfigs($configService, $bundles);
        $this->mergeProvideConfig($configService);
    }

    private function mergeBundleConfigs(ConfigService $configService, array $bundles)
    {
        /** @var \Application\Bundle\Bundle[] $bundles */
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
                ->reduce(function ($carry, $config) use ($configService) {
                    $configService->merge($config);
                });
        }
    }

    private function mergeProvideConfig(ConfigService $configService)
    {
        $provideConfigFileName = sprintf('%s/provide/provide.config.php', $this->backendPath);

        if(file_exists($provideConfigFileName)) {
            $provideConfig = require $provideConfigFileName;

            $configService->merge($provideConfig);
        }
    }
}