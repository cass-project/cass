<?php
namespace Post\Middleware\Command;


use Application\REST\Exceptions\UnknownActionException;
use Auth\Service\CurrentProfileService;
use Post\Service\AttachmentService;
use Post\Service\PostService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{

	private $postService;
	private $currentProfileService;
	private $attachmentService;

	/**
	 * @return AttachmentService
	 */
	public function getAttachmentService():AttachmentService{
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

	/**
	 * @return CurrentProfileService
	 */
	public function getCurrentProfileService():CurrentProfileService
	{
		return $this->currentProfileService;
	}

	/**
	 * @param mixed $currentProfileService
	 */
	public function setCurrentProfileService(CurrentProfileService $currentProfileService)
	{
		$this->currentProfileService = $currentProfileService;
	}

	/**
	 * @return PostService
	 */
	public function getPostService():PostService
	{
		return $this->postService;
	}

	/**
	 * @param PostService $postService
	 */
	public function setPostService(PostService $postService)
	{
		$this->postService = $postService;
	}

	abstract public function run(ServerRequestInterface $request);

	static public function factory(ServerRequestInterface $request):Command
	{
		$action = $request->getAttribute('command');

		switch ($action) {
			case 'create':
				return new CreatePostCommand();
			break;
			case 'read':
				return new ReadPostCommand();
			break;
			case 'update':
				return new UpdatePostCommand();
			break;
			case 'delete-post':
				return new DeletePostCommand();
			break;
			case 'delete-attachment':


				return new DeleteAttachmentCommand();
			break;

			case 'parse': {
				return new ParseUrl();
			break;
			}


		}


		throw new UnknownActionException('Unknown action');
	}
}