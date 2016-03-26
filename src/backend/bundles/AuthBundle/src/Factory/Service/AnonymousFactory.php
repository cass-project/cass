<?php
namespace Auth\Factory\Service;

use Auth\Service\Anonymous;
use Data\Repository\AccountRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AnonymousFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountRepository = $container->get(AccountRepository::class); /** @var AccountRepository $accountRepository */

        return new Anonymous($accountRepository);
    }
}