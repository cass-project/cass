<?php
namespace Collection\Factory\Repository;

use Collection\Entity\Collection;
use Collection\Repository\CollectionRepository;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CollectionRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): CollectionRepository
    {
        $em = $container->get(EntityManager::class); /** @var EntityManager $em */

        return $em->getRepository(Collection::class);
    }
}