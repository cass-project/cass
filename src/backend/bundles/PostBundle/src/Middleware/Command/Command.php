<?php
/**
 * User: юзер
 * Date: 18.03.2016
 * Time: 15:19
 * To change this template use File | Settings | File Templates.
 */

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
				return new ReadCommand();
			break;
			case 'update':
				return new UpdateCommand();
			break;
			case 'delete':
				return new DeleteCommand();
			break;

		}


		throw new UnknownActionException('Unknown action');
	}
}