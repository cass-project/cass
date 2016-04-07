<?php
/**
 * Created by PhpStorm.
 * User: CoffeeTurbo
 * Date: 23.03.2016
 * Time: 16:05
 */

namespace Data\Factory\Repository;


use Data\Entity\Post;
use Data\Repository\Post\PostRepository;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class PostRepositoryFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL){
		$entityManager = $container->get(EntityManager::class); /** @var EntityManager $entityManager */

		return $entityManager->getRepository(Post::class);
	}

}