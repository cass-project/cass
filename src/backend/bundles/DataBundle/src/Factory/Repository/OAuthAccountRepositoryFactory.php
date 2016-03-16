<?php
namespace Data\Factory\Repository;

use Data\Entity\OAuthAccount;
use Data\Repository\OAuthAccountRepository;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class OAuthAccountRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): OAuthAccountRepository
    {
        $entityManager = $container->get(EntityManager::class); /** @var EntityManager $entityManager */

        return $entityManager->getRepository(OAuthAccount::class);
    }
}