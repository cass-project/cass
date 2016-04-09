<?php
namespace Profile\Factory\Middleware;

use Interop\Container\ContainerInterface;
use Profile\Middleware\ProfileMiddleware;
use Profile\Repository\ProfileRepository;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProfileMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $profileRepository = $container->get(ProfileRepository::class); /** @var ProfileRepository $profileRepository */

        return new ProfileMiddleware($profileRepository);
    }
}