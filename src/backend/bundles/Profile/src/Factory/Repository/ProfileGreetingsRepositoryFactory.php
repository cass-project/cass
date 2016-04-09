<?php
namespace Profile\Factory\Repository;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Profile\Entity\ProfileGreetings;
use Profile\Repository\ProfileGreetingsRepository;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProfileGreetingsRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): ProfileGreetingsRepository
    {
        /** @var EntityManager $em */
        $em = $container->get(EntityManager::class);

        return $em->getRepository(ProfileGreetings::class);
    }
}