<?php
namespace Auth\Factory\Service;

use Account\Service\AccountService;
use Common\Service\SharedConfigService;
use Auth\Service\AuthService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountService = $container->get(AccountService::class); /** @var AccountService $accountService */
        $sharedConfigService = $container->get(SharedConfigService::class); /** @var SharedConfigService $sharedConfigService */

        return new AuthService($accountService, $sharedConfigService->get('oauth2_providers'));
    }
}