<?php
namespace Feed\Factory\Middleware;

use Common\Service\SchemaService;
use Feed\Middleware\FeedMiddleware;
use Interop\Container\ContainerInterface;
use Sphinx\SphinxClient;
use Zend\ServiceManager\Factory\FactoryInterface;

class FeedMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): FeedMiddleware
    {
        $schemaService = $container->get(SchemaService::class);
        $sphinxClient = $container->get(SphinxClient::class);
        return new FeedMiddleware($sphinxClient,$schemaService);

    }
}