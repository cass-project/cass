<?php
namespace Channel\Factory\Service;

use Channel\Service\ChannelService;
use Data\Repository\Channel\ChannelRepository;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * User: юзер
 * Date: 09.03.2016
 * Time: 13:40
 * To change this template use File | Settings | File Templates.
 */
class ChannelServiceFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL): ChannelService
	{
		$channelRepository = $container->get(ChannelRepository::class);
		return new ChannelService($channelRepository);
	}

}