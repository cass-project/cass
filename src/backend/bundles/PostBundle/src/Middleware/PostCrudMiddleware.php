<?php
/**
 * User: юзер
 * Date: 18.03.2016
 * Time: 13:36
 * To change this template use File | Settings | File Templates.
 */

namespace Post\Middleware;


use Application\REST\GenericRESTResponseBuilder;
use Post\Service\PostService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class PostCRUDMiddleware implements MiddlewareInterface
{

	private $postSevice;
	public function __construct(PostService $postService){
		$this->postSevice = $postService;
	}


	public function __invoke(Request $request, Response $response, callable $out = NULL){
		$responseBuilder = new GenericRESTResponseBuilder($response);

		return $responseBuilder->build();
	}
}