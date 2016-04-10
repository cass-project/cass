<?php
namespace Auth\Factory\Service;

use Account\Service\AccountService;
use Common\Service\SharedConfigService;
use Auth\Service\AuthService;
use Account\Repository\AccountRepository;
use Account\Repository\OAuthAccountRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountRepository = $container->get(AccountRepository::class); /** @var \Account\Repository\AccountRepository $accountRepository */
        $oauthAccountRepository = $container->get(OAuthAccountRepository::class); /** @var OAuthAccountRepository $oauthAccountRepository */
        $accountService = $container->get(AccountService::class); /** @var AccountService $accountService */
        $sharedConfigService = $container->get(SharedConfigService::class); /** @var SharedConfigService $sharedConfigService */

        return new AuthService($accountService, $accountRepository, $oauthAccountRepository, $sharedConfigService->get('oauth2_providers'));
    }
}