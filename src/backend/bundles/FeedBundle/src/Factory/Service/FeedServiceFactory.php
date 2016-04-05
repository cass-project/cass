<?php
namespace Feed\Factory\Service;

use Feed\Service\FeedService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class FeedServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): FeedService
    {
        return new FeedService();
    }
}