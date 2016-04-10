<?php
namespace Account\Factory\Service;

use Account\Service\AccountService;
use Account\Repository\AccountRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Account\Repository\OAuthAccountRepository;

class AccountServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountRepository = $container->get(AccountRepository::class);
        $oauthRepository = $container->get(OAuthAccountRepository::class);

        return new AccountService($accountRepository, $oauthRepository);
    }
}