<?php
namespace Development\Factory\Service;

use Application\Bootstrap\Bundle\BundleService;
use Interop\Container\ContainerInterface;
use Development\Service\APIDocsService;
use Zend\ServiceManager\Factory\FactoryInterface;

class APIDocsServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $bundleService = $container->get(BundleService::class); /** @var BundleService $bundleService */

        return new APIDocsService($bundleService);
    }

}