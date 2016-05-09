<?php
namespace Application\Bootstrap\Scripts\Bootstrap;

use DI\Container;
use DI\ContainerBuilder;
use Application\Bootstrap\AppBuilder;
use Application\Bootstrap\Scripts\BootstrapScript;
use Application\Service\BundleService;
use Application\Service\ConfigService;

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