<?php
namespace Channel\Middleware;
use Application\REST\GenericRESTResponseBuilder;
use Channel\Middleware\Command\Command;
use Channel\Service\ChannelService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;


class ChannelCRUDMiddleware implements MiddlewareInterface
{

	/** @var ChannelService  */
	private $channelServicel;

	public function __construct(ChannelService $channelServicel)
	{
		$this->channelServicel = $channelServicel;
	}

	public function __invoke(Request $request, Response $response, callable $out = NULL){
		$responseBuilder = new GenericRESTResponseBuilder($response);

		try {
			$command = Command::factory($request);
//			$command->setAuthService($this->authService);
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