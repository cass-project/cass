<?php
namespace Development\Factory\Service;

use Development\Service\DumpConfigService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DumpConfigServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new DumpConfigService($container);
    }
}