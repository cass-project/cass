<?php
namespace Common\Factory\Service;

use Common\Service\FrontlineService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class FrontlineServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new FrontlineService();
    }
}