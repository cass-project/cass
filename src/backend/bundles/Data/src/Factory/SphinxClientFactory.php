<?php
namespace Data\Factory;

use Common\Service\SharedConfigService;
use Interop\Container\ContainerInterface;
use Sphinx\SphinxClient;
use Zend\ServiceManager\Factory\FactoryInterface;

class SphinxClientFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $sharedConfigService = $container->get(SharedConfigService::class);
        $config = $sharedConfigService->get('sphinx');

        $sphinx = SphinxClient::create();
        $sphinx->SetServer($config["connection_options"]["server"]);

        return $sphinx;
    }
}