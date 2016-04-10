<?php
namespace Post\Middleware\Command;


use Common\REST\Exceptions\UnknownActionException;
use Post\Middleware\Request\PutPostAttachmentRequest;
use Post\Middleware\Request\PutPostRequest;
use Post\Service\AttachmentService;
use Post\Service\PostService;
use Psr\Http\Message\ServerRequestInterface;

abstract class AttachmentCommand
{
	/** @var  AttachmentService */
	private $attachmentService;

	private $postService;

	/**
	 * @return PostService
	 */
	public function getPostService():PostService
	{
		return $this->postService;
	}

	/**
	 * @param PostService $postService
	 *
	 * @return $this
	 */
	public function setPostService(PostService $postService)
	{
		$this->postService = $postService;
		return $this;
	}

	/**
	 * @return AttachmentService
	 */
	public function getAttachmentService():AttachmentService
	{
		return $this->attachmentService;
	}

	/**
	 * @param AttachmentService $attachmentService
	 *
	 * @return $this
	 */
	public function setAttachmentService(AttachmentService $attachmentService)
	{
		$this->attachmentService = $attachmentService;
		return $this;
	}

	abstract public function run(ServerRequestInterface $request);

	static public function factory(ServerRequestInterface $request):Command
	{
		$action = $request->getAttribute('command');

		switch ($action) {

			case 'add':

				$json_r = json_decode($request->getBody(), true);
				if(isset($json_r['post_id']) && $json_r['post_id']){
					// добавляем аттачмент
					return new CreateAttachmentCommand();

				} else {
					// создаём пост и
					// добавляем аттачмент

					/*$post = $this->getPostService()->create(
						(new PutPostRequest($request))->getParameters()
					);

					$attachment = $this->getAttachmentService()->create(
						(new PutPostAttachmentRequest($request))->getParameters()
					);

					$post->addAttachment($attachment);
					$this->getPostService()->save($post);*/

				}
			break;

			case 'delete':
				return new DeleteAttachmentCommand();
			break;
		}

		throw new UnknownActionException('Unknown action');
	}
}