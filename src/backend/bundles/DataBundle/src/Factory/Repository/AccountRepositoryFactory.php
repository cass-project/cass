<?php
namespace Data\Factory\Repository;

use Data\Entity\Account;
use Data\Repository\AccountRepository;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AccountRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): AccountRepository
    {
        $entityManager = $container->get(EntityManager::class); /** @var EntityManager $entityManager */

        return $entityManager->getRepository(Account::class);
    }
}