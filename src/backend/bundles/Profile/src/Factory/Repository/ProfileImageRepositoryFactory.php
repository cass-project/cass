<?php
namespace Profile\Factory\Repository;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Profile\Entity\ProfileImage;
use Profile\Repository\ProfileImageRepository;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProfileImageRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): ProfileImageRepository
    {
        /** @var EntityManager $em */
        $em = $container->get(EntityManager::class);

        return $em->getRepository(ProfileImage::class);
    }
}