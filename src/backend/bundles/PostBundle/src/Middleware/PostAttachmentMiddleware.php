<?php
namespace Post\Middleware;


use Application\REST\GenericRESTResponseBuilder;
use Post\Middleware\Request\PutPostAttachmentRequest;
use Post\Service\AttachmentService;
use Post\Service\PostService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class PostAttachmentMiddleware implements MiddlewareInterface
{
	/**
	 * @var PostService
	 */
	private $postService;

	/**
	 * @var AttachmentService
	 */
	private $attachmentService;
	public function __construct(PostService $postService, AttachmentService $attachmentService)
	{
		$this->postService       = $postService;
		$this->attachmentService = $attachmentService;
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

			case 'add': {

				$json_r = json_decode($request->getBody());
				$r=[];

				if(isset($json_r->post_id) && $json_r->post_id){
					// добавляем аттачмент
					$postAttachmentParam = (new PutPostAttachmentRequest($request))->getParameters();

					$attachment = $this->attachmentService->create($postAttachmentParam);

					$r = $attachment->toJSON();

				} else {
					// создаём пост и
					// добавляем аттачмент
					die("Создаём пост и аттач");

				}

				return $responseBuilder
					->setStatusSuccess()
					->setJson([
											'result'  => $r,
											'success' => TRUE
										]
					)
					->build()
					;
				break;
			}
		}
	}

}