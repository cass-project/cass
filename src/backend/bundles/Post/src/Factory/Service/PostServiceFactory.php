<?php
namespace Post\Factory\Service;


use Data\Repository\Post\PostRepository;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Post\Service\PostService;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class PostServiceFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL){

		$postRepository = $container->get(PostRepository::class);

		return new PostService($postRepository);
	}

}