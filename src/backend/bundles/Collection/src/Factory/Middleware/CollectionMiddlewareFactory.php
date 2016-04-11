<?php
namespace Collection\Factory\Middleware;

use Auth\Service\CurrentAccountService;
use Collection\Middleware\CollectionMiddleware;
use Collection\Service\CollectionService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CollectionMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $collectionService = $container->get(CollectionService::class); /** @var CollectionService $collectionService */
        $currentAccountService = $container->get(CurrentAccountService::class); /** @var CurrentAccountService $currentAccountService */

        return new CollectionMiddleware($collectionService, $currentAccountService);
    }
}