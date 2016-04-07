<?php
/**
 * User: юзер
 * Date: 09.03.2016
 * Time: 15:42
 * To change this template use File | Settings | File Templates.
 */

namespace Data\Factory\Repository;


use Data\Entity\Channel;
use Data\Repository\Channel\ChannelRepository;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ChannelRepositoryFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL):ChannelRepository
	{
		$entityManager = $container->get(EntityManager::class); /** @var EntityManager $entityManager */

		return $entityManager->getRepository(Channel::class);
	}

}