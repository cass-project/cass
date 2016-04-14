<?php
namespace Data\Factory\Repository;


use Data\Entity\Attachment;
use Data\Repository\Attachment\AttachmentRepository;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class AttachmentRepositoryFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL){

		$entityManager = $container->get(EntityManager::class); /** @var EntityManager $entityManager */

		return $entityManager->getRepository(Attachment::class);
	}

}