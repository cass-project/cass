<?php
namespace Channel\Middleware\Command;


use Application\REST\GenericRESTResponseBuilder;
use Channel\Service\ChannelService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
	private $channelService;

	public function getChannelService():ChannelService
	{
		return $this->channelService;
	}

	public function setChannelService(ChannelService $channelService):self
	{
		$this->channelService = $channelService;
		return $this;
	}


	static public function factory(ServerRequestInterface $request)
	{
		$action = $request->getAttribute('command');

		switch ($action) {
			case 'create':
				return new CreateCommand();
			break;
			case 'read':
				return new ReadCommand();
			break;
			case 'update': break;
			case 'delete': break;

		}


		throw new UnknownActionException('Unknown action');
	}


	abstract public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder);
}