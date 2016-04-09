<?php
namespace Auth\Factory\Repository;

use Auth\Entity\OAuthAccount;
use Auth\Repository\OAuthAccountRepository;
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