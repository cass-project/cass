<?php
namespace Post\Middleware;


use Common\REST\GenericRESTResponseBuilder;
use Auth\Service\CurrentAccountService;
use Post\Middleware\Command\Command;
use Post\Service\PostService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class PostMiddleware implements MiddlewareInterface
{

	private $postSevice;
	private $currentAccountService;

	public function __construct(PostService $postService, CurrentAccountService $currentAccountService ){
		$this->postSevice = $postService;
		$this->currentAccountService = $currentAccountService;
	}


	public function __invoke(Request $request, Response $response, callable $out = NULL){
		$responseBuilder = new GenericRESTResponseBuilder($response);

		$command = Command::factory($request);
		$command->setPostService($this->postSevice);
		$command->setCurrentAccountService($this->currentAccountService);

		return $responseBuilder
			->setStatusSuccess()
			->setJson($command->run($request))
			->build()
		;
	}
}