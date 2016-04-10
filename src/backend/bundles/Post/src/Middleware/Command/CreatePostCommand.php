<?php
namespace Post\Middleware\Command;


use Common\Tools\RequestParams\Param;
use Post\Middleware\Request\PutPostRequest;
use Psr\Http\Message\ServerRequestInterface;

class CreatePostCommand extends Command
{

	public function run(ServerRequestInterface $request){
		$postService= $this->getPostService();

		$account = $this->getCurrentProfileService()->getCurrentAccount();

		$post = $postService->create(
			(new PutPostRequest($request))
															->getParameters()
															->setAccountId($account->getId())
															->publish()
		);

		return [
			'id' => $post->getId(),
			'entity'=> $post->toJSON()
		];
	}
}