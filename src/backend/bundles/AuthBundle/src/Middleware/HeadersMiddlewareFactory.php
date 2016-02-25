<?php
namespace Auth\Middleware;

use Auth\Service\AuthService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class HeadersMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authService = $container->get(AuthService::class);

        return new HeadersMiddleware($authService);
    }
}