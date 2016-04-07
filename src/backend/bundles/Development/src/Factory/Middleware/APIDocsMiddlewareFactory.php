<?php
namespace Development\Factory\Middleware;

use Interop\Container\ContainerInterface;
use Development\Middleware\APIDocsMiddleware;
use Development\Service\APIDocsService;
use Zend\ServiceManager\Factory\FactoryInterface;

class APIDocsMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $apiDocsService = $container->get(APIDocsService::class); /** @var APIDocsService $apiDocsService */

        return new APIDocsMiddleware($apiDocsService);
    }
}