<?php
namespace Auth\Service;

use Application\Service\SharedConfigService;
use Data\Repository\AccountRepository;
use Data\Repository\OAuthAccountRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountRepository = $container->get(AccountRepository::class); /** @var AccountRepository $accountRepository */
        $oauthAccountRepository = $container->get(OAuthAccountRepository::class); /** @var OAuthAccountRepository $oauthAccountRepository */
        $sharedConfigService = $container->get(SharedConfigService::class); /** @var SharedConfigService $sharedConfigService */

        return new AuthService($accountRepository, $oauthAccountRepository, $sharedConfigService->get('oauth2_providers'));
    }
}