<?php
namespace Profile\Factory\Middleware;

use Interop\Container\ContainerInterface;
use Profile\Middleware\ProfileMiddleware;
use Profile\Service\ProfileService;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProfileMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $profileService = $container->get(ProfileService::class); /** @var ProfileService $profileService */

        return new ProfileMiddleware($profileService);
    }
}