<?php
namespace Profile\Factory\Middleware;

use Auth\Service\CurrentAccountService;
use Interop\Container\ContainerInterface;
use Profile\Middleware\ProfileMiddleware;
use Profile\Service\ProfileService;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProfileMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $profileService = $container->get(ProfileService::class); /** @var ProfileService $profileService */
        $currentAccountService = $container->get(CurrentAccountService::class); /** @var CurrentAccountService $currentAccountService */

        return new ProfileMiddleware($profileService, $currentAccountService);
    }
}