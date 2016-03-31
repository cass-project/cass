<?php
namespace Feed\Factory\Middleware;

use Application\Service\SchemaService;
use Feed\Middleware\FeedMiddleware;
use Interop\Container\ContainerInterface;
use Sphinx\SphinxClient;
use Zend\ServiceManager\Factory\FactoryInterface;

class FeedMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): FeedMiddleware
    {
        $schemaService = $container->get(SchemaService::class);
        $sphinxService = $container->get(SphinxClient::class);
        return new FeedMiddleware($sphinxService,$schemaService);

    }
}