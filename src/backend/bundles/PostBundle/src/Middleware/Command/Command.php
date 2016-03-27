<?php
namespace Post\Middleware\Command;


use Application\REST\Exceptions\UnknownActionException;
use Auth\Service\CurrentProfileService;
use Post\Service\PostService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{

	private $postService;
	private $currentProfileService;

	/**
	 * @return CurrentProfileService
	 */
	public function getCurrentProfileService():CurrentProfileService{
		return $this->currentProfileService;
	}

	/**
	 * @param mixed $currentProfileService
	 */
	public function setCurrentProfileService(CurrentProfileService $currentProfileService){
		$this->currentProfileService = $currentProfileService;
	}

	/**
	 * @return PostService
	 */
	public function getPostService():PostService{
		return $this->postService;
	}

	/**
	 * @param PostService $postService
	 */
	public function setPostService(PostService $postService){
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
			case 'delete':
				return new DeleteCommand();
			break;

		}


		throw new UnknownActionException('Unknown action');
	}
}