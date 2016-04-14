<?php
namespace EmailVerification\Factory\Repository;

use Doctrine\ORM\EntityManager;
use EmailVerification;
use EmailVerification\Repository\EmailVerificationRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class EmailVerificationRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): EmailVerificationRepository
    {
        $em = $container->get(EntityManager::class); /** @var EntityManager $em */

        return $em->getRepository(EmailVerification::class);
    }
}