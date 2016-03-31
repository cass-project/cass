<?php
namespace Channel\Middleware;
use Application\REST\Exceptions\UnknownActionException;
use Application\REST\GenericRESTResponseBuilder;
use Auth\Service\AuthService;
use Auth\Service\CurrentProfileService;
use Channel\Middleware\Command\Command;
use Channel\Service\ChannelService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;


class ChannelCRUDMiddleware implements MiddlewareInterface
{

	/** @var ChannelService  */
	private $channelService;

	/**
	 * @return ChannelService
	 */
	public function getChannelService():ChannelService{
		return $this->channelService;
	}

	/**
	 * @param ChannelService $channelService
	 *
	 * @return $this
	 */
	public function setChannelService(ChannelService $channelService){
		$this->channelService = $channelService;
		return $this;
	}

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


	public function __construct(ChannelService $channelService, CurrentProfileService $currentProfileService)
	{
		$this->channelService = $channelService;
		$this->currentProfileService = $currentProfileService;
	}

	public function __invoke(Request $request, Response $response, callable $out = NULL){
		$responseBuilder = new GenericRESTResponseBuilder($response);

		try {
			$command = Command::factory($request);
			$command->setChannelService($this->channelService);
			$command->setCurrentProfileService($this->currentProfileService);

			$command->run($request, $responseBuilder);
		} catch (UnknownActionException $e) {
			$responseBuilder
				->setStatusBadRequest()
				->setError($e)
			;
		}

		return $responseBuilder->build();
	}

}