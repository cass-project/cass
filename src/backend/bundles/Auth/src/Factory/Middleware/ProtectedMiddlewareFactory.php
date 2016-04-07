<?php
namespace Auth\Factory\Middleware;

use Auth\Middleware\ProtectedMiddleware;
use Auth\Service\CurrentProfileService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProtectedMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $currentProfileService = $container->get(CurrentProfileService::class); /** @var CurrentProfileService $currentProfileService */
        $paths = $container->get('paths');

        return new ProtectedMiddleware($currentProfileService, $paths['prefix']);
    }
}