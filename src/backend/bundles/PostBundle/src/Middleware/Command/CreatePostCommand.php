<?php
namespace Post\Middleware\Command;


use Post\Middleware\Request\PutPostRequest;
use Psr\Http\Message\ServerRequestInterface;

class CreatePostCommand extends Command
{

	public function run(ServerRequestInterface $request){
		$postService= $this->getPostService();


		$post = $postService->create((new PutPostRequest($request))->getParameters());


		return [
			'id' => $post->getId(),
			'entity'=> $post->toJSON()
		];
	}
}