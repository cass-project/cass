<?php
namespace Collection\Factory\Service;

use Auth\Service\CurrentAccountService;
use Collection\Repository\CollectionRepository;
use Collection\Service\CollectionService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CollectionServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): CollectionService
    {
        $collectionRepository = $container->get(CollectionRepository::class); /** @var CollectionRepository $collectionRepository */
        $currentAccountService = $container->get(CurrentAccountService::class); /** @var CurrentAccountService $currentAccountService */

        return new CollectionService($collectionRepository, $currentAccountService);
    }
}