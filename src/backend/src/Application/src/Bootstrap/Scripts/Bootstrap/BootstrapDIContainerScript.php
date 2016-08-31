<?php
namespace CASS\Application\Bootstrap\Scripts\Bootstrap;

use DI\Container;
use DI\ContainerBuilder;
use CASS\Application\Bootstrap\AppBuilder;
use CASS\Application\Bootstrap\Scripts\BootstrapScript;
use CASS\Application\Service\BundleService;
use CASS\Application\Service\ConfigService;

class BootstrapDIContainerScript implements BootstrapScript
{
    public function __invoke(AppBuilder $appBuilder) {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions($appBuilder->getConfigService()->get('php-di'));
        $containerBuilder->addDefinitions([
            BundleService::class => $appBuilder->getBundleService(),
            ConfigService::class => $appBuilder->getConfigService(),
        ]);

        $container = $containerBuilder->build();
        $container->set(Container::class, $container);

        $appBuilder->setContainer($container);
    }
}