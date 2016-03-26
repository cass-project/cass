<?php
/**
 * User: юзер
 * Date: 18.03.2016
 * Time: 15:02
 * To change this template use File | Settings | File Templates.
 */

namespace Post\Factory\Middleware;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Post\Middleware\PostCRUDMiddleware;
use Post\Service\PostService;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class PostCRUDMIddlewareFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL){
		$postService = $container->get(PostService::class);

		return new PostCRUDMiddleware($postService);
	}

}