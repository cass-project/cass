<?php
namespace Channel\Middleware\Command;


use Application\REST\Exceptions\UnknownActionException;
use Application\REST\GenericRESTResponseBuilder;
use Auth\Service\AuthService;
use Auth\Service\CurrentProfileService;
use Channel\Service\ChannelService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
	/**
	 * @var ChannelService
	 */
	private $channelService;

	/**
	 * @var CurrentProfileService
	 */
	private $currentProfileService;

	/**
	 * @return CurrentProfileService
	 */
	public function getCurrentProfileService():CurrentProfileService
	{
		return $this->currentProfileService;
	}

	/**
	 * @param CurrentProfileService $currentProfileService
	 *
	 * @return $this
	 */
	public function setCurrentProfileService(CurrentProfileService $currentProfileService){
		$this->currentProfileService = $currentProfileService;
		return $this;
	}

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
			case 'delete':
				return new DeleteCommand();
			break;
			case 'update':
				return new UpdateCommand();
			break;
		}


		throw new UnknownActionException('Unknown action');
	}


	abstract public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder);
}