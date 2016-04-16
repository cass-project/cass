<?php
namespace Swagger\Factory\Middleware;

use Interop\Container\ContainerInterface;
use Swagger\Middleware\APIDocsMiddleware;
use Swagger\Service\APIDocsService;
use Zend\ServiceManager\Factory\FactoryInterface;

class APIDocsMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $apiDocsService = $container->get(APIDocsService::class); /** @var \Swagger\Service\APIDocsService $apiDocsService */

        return new APIDocsMiddleware($apiDocsService);
    }
}