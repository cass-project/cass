<?php
namespace Channel\Middleware\Command;


use Application\REST\GenericRESTResponseBuilder;
use Channel\Service\ChannelService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
	private $channelService;

	static public function factory(ServerRequestInterface $request)
	{
		$action = $request->getAttribute('action');

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

	public function setChannelService(ChannelService $channelService){
		$this->channelService = $channelService;
	}

	abstract public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder);
}