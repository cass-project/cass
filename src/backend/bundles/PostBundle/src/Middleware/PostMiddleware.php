<?php
namespace Post\Middleware;


use Application\REST\GenericRESTResponseBuilder;
use Post\Service\PostService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class PostMiddleware implements MiddlewareInterface
{

	private $postService;
	public function __construct(PostService $postService){
		$this->postService = $postService;
	}

	public function __invoke(Request $request, Response $response, callable $out = NULL){
		$responseBuilder = new GenericRESTResponseBuilder($response);
		switch($request->getAttribute('command')){
			default :{
				return $responseBuilder
					->setStatusNotFound()
					->build()
					;
			}

			case 'parse': {
				// парсим урл и
				$data = json_decode($request->getBody(), true);
				$opts = $this->postService->getLinkOptions($data['url']);

				return $responseBuilder
					->setStatusSuccess()
					->setJson($opts)
					->build()
					;
				break;
			}
		}
	}
}