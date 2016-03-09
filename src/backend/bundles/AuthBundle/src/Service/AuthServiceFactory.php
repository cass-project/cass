<?php
namespace Auth\Service;

use Data\Repository\AccountRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountRepository = $container->get(AccountRepository::class); /** @var AccountRepository $accountRepository */

        return new AuthService($accountRepository);
    }
}