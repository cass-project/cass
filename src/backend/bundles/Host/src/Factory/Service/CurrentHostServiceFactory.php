<?php
namespace Host\Factory\Service;

use Data\Repository\HostRepository;
use Host\Service\CurrentHostService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CurrentHostServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): CurrentHostService
    {
        $hostRepository = $container->get(HostRepository::class); /** @var HostRepository $hostRepository */

        return new CurrentHostService($hostRepository);
    }
}