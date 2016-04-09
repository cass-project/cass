<?php
namespace Profile\Factory\Repository;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Profile\Entity\Profile;
use Profile\Repository\ProfileRepository;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProfileRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): ProfileRepository
    {
        /** @var EntityManager $em */
        $em = $container->get(EntityManager::class);

        return $em->getRepository(Profile::class);
    }
}