<?php
namespace Auth\Factory\Service;

use Auth\Service\CurrentProfileService;
use Account\Repository\AccountRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CurrentProfileServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountRepository = $container->get(AccountRepository::class); /** @var \Account\Repository\AccountRepository $accountRepository */

        return new CurrentProfileService($accountRepository);
    }
}