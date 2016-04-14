<?php
namespace Post\Middleware;


use Auth\Service\CurrentAccountService;
use Common\REST\GenericRESTResponseBuilder;
use Post\Middleware\Command\AttachmentCommand;
use Post\Middleware\Command\Command;
use Post\Middleware\Command\CreateAttachmentCommand;
use Post\Middleware\Request\PutPostAttachmentRequest;
use Post\Middleware\Request\PutPostRequest;
use Post\Service\AttachmentService;
use Post\Service\PostService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class AttachmentMiddleware implements MiddlewareInterface
{
	/**
	 * @var PostService
	 */
	private $postService;

	/**
	 * @var AttachmentService
	 */
	private $attachmentService;

	/**
	 * @var CurrentAccountService
	 */
	private $currentAccountService;

	public function __construct(PostService $postService, AttachmentService $attachmentService,CurrentAccountService $currentAccountService)
	{

		$this->postService       = $postService;
		$this->attachmentService = $attachmentService;
		$this->currentAccountService = $currentAccountService;
	}


	public function __invoke(Request $request, Response $response, callable $out = NULL){

		$responseBuilder = new GenericRESTResponseBuilder($response);

		$command = AttachmentCommand::factory($request);
		$command->setPostService($this->postService);
		$command->setCurrentAccountService($this->currentAccountService);
		$command->setAttachmentService($this->attachmentService);

		return $responseBuilder
			->setStatusSuccess()
			->setJson($command->run($request))
			->build()
		;
	}

}