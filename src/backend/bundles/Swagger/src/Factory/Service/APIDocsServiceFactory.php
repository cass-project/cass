<?php
namespace Swagger\Factory\Service;

use Common\Bootstrap\Bundle\BundleService;
use Interop\Container\ContainerInterface;
use Swagger\Service\APIDocsService;
use Zend\ServiceManager\Factory\FactoryInterface;

class APIDocsServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $bundleService = $container->get(BundleService::class); /** @var BundleService $bundleService */

        return new APIDocsService($bundleService);
    }

}