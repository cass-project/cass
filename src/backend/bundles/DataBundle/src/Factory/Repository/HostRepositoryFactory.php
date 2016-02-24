<?php
namespace Data\Factory\Repository;

use Data\Entity\Host;
use Data\Repository\HostRepository;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class HostRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): HostRepository
    {
        $entityManager = $container->get(EntityManager::class); /** @var EntityManager $entityManager */

        return $entityManager->getRepository(Host::class);
    }
}