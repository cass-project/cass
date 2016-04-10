<?php
namespace Auth\Factory\Middleware;

use Auth\Middleware\ProtectedMiddleware;
use Auth\Service\CurrentAccountService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProtectedMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $currentAccountService = $container->get(CurrentAccountService::class); /** @var CurrentAccountService $currentAccountService */
        $paths = $container->get('paths');

        return new ProtectedMiddleware($currentAccountService, $paths['prefix']);
    }
}