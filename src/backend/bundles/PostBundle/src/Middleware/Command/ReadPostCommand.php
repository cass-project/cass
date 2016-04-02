<?php
/**
 * Created by PhpStorm.
 * User: CoffeeTurbo
 * Date: 27.03.2016
 * Time: 19:23
 */

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