<?php
namespace Auth\Factory\Middleware;

use Auth\Middleware\AuthMiddleware;
use Auth\Service\AuthService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authService = $container->get(AuthService::class);

        return new AuthMiddleware($authService);
    }
}