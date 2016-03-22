<?php
/**
 * Created by PhpStorm.
 * User: CoffeeTurbo
 * Date: 22.03.2016
 * Time: 14:21
 */

namespace Post\Factory\Service;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Post\Service\PostService;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class PostServiceFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL){
		return new PostService();
	}

}