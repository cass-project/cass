<?php
namespace Application\Bootstrap\Scripts;

use DI\Container;
use DI\ContainerBuilder;
use Application\Bootstrap\AppBuilder;
use Application\Bootstrap\InitScript;
use Application\Service\BundleService;
use Application\Service\ConfigService;

class InitDIContainerScript implements InitScript
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