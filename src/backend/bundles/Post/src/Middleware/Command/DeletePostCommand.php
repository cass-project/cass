<?php
namespace Post\Middleware\Command;


use Psr\Http\Message\ServerRequestInterface;

class DeletePostCommand extends Command
{
	public function run(ServerRequestInterface $request)
	{
		$postId = $request->getAttribute('postId');
		return $this->getPostService()->getPostRepository()->delete($postId)->toJSON();
	}

}