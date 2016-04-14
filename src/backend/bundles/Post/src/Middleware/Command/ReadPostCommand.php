<?php
namespace Post\Middleware\Command;


use Psr\Http\Message\ServerRequestInterface;

class ReadPostCommand extends Command
{

	public function run(ServerRequestInterface $request){
		$service = $this->getPostService();
		$response = [];
		if($request->getAttribute('postId')){

			$postId = $request->getAttribute('postId');
			$post = $service->getPostRepository()->getPostWithAttachments($postId);
			$response = [
				'success' => true,
				'entity'  => $post,
			];
		} else {
			$posts = $service->getPostRepository()->getPosts();
			$response = [
				'success' 	=> true,
				'total'			=> count($posts),
				'entities'  => $posts,
			];
		}
		return $response;
	}

}