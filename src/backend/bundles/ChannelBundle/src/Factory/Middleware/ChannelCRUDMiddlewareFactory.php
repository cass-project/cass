<?php
/**
 * User: юзер
 * Date: 09.03.2016
 * Time: 13:44
 * To change this template use File | Settings | File Templates.
 */

namespace Channel\Factory\Middleware;


use Channel\Middleware\ChannelCRUDMiddleware;
use Channel\Service\ChannelService;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ChannelCRUDMiddlewareFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL):ChannelCRUDMiddleware
	{
		$channelsService = $container->get(ChannelService::class);
		return new ChannelCRUDMiddleware($channelsService);
	}

}