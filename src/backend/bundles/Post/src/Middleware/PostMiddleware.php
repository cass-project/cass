<?php
namespace Post\Middleware;


use Application\REST\GenericRESTResponseBuilder;
use Auth\Service\CurrentProfileService;
use Post\Middleware\Command\Command;
use Post\Service\PostService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class PostMiddleware implements MiddlewareInterface
{

	private $postSevice;
	private $currentProfileService;

	public function __construct(PostService $postService, CurrentProfileService $currentProfileService ){
		$this->postSevice = $postService;
		$this->currentProfileService = $currentProfileService;
	}


	public function __invoke(Request $request, Response $response, callable $out = NULL){
		$responseBuilder = new GenericRESTResponseBuilder($response);

		$command = Command::factory($request);
		$command->setPostService($this->postSevice);
		$command->setCurrentProfileService($this->currentProfileService);

		$responseBuilder
			->setStatusSuccess()
			->setJson($command->run($request))
			->build()
		;
	}
}