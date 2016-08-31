<?php
namespace CASS\Application\Bootstrap\Scripts\Bootstrap;

use CASS\Application\Bootstrap\AppBuilder;
use CASS\Application\Bootstrap\Scripts\BootstrapScript;
use CASS\Application\Bundle\Bundle;
use CASS\Application\Service\ConfigService;
use Cocur\Chain\Chain;

class ReadAppConfigScript implements BootstrapScript
{
    public function __invoke(AppBuilder $appBuilder)
    {
        $configService = new ConfigService();

        $this->mergeBundleConfigs($configService, $appBuilder->getBundleService()->getBundles());
        $this->mergeProvideConfig($configService, $configService->get('php-di')['paths']['backend']);
        $this->mergeEnvConfig($configService, $this->getEnv($configService, $appBuilder));

        $appBuilder->setConfigService($configService);
    }

    private function mergeBundleConfigs(ConfigService $configService, array $bundles)
    {
        array_walk($bundles, function(Bundle $bundle) use ($configService) {
            $dir = $bundle->getConfigDir();

            if(is_dir($dir)) {
                Chain::create(scandir($dir))
                    ->filter(function($input) use ($dir) {
                        return is_file($dir . '/' . $input) && preg_match('/\.config.php$/', $input);
                    })
                    ->map(function($input) use ($dir) {
                        return require $dir . '/' . $input;
                    })
                    ->map(function(array $config) use ($configService) {
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

    private function mergeEnvConfig(ConfigService $configService, string $env)
    {
        if(! strlen($env)) {
            throw new \Exception('Empty environment');
        }

        $configService->merge([
            'ENVIRONMENT' => $env,
            'php-di' => [
                'config.env' => $env
            ]
        ]);

        if($configService->has('env')) {
            $envConfigs = $configService->get('env');

            if(isset($envConfigs[$env]) && is_array($envConfigs[$env])) {
                $configService->merge($envConfigs[$env]);
            }
        }
    }

    private function getEnv(ConfigService $configService, AppBuilder $appBuilder): string
    {
        $env = 'development';

        if($appBuilder->isEnvSpecified()) {
            $env = $appBuilder->getEnv();
        } else if($configService->has('ENVIRONMENT')) {
            $env = $configService->get('ENVIRONMENT');
        }

        return $env;
    }
}