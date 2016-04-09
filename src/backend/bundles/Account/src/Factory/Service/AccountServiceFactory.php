<?php
namespace Account\Factory\Service;

use Account\Service\AccountService;
use Auth\Repository\AccountRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AccountServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountRepository = $container->get(AccountRepository::class);

        return new AccountService($accountRepository);
    }
}