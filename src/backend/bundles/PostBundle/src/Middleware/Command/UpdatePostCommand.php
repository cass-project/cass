<?php
/**
 * Created by PhpStorm.
 * User: CoffeeTurbo
 * Date: 27.03.2016
 * Time: 20:34
 */

namespace Post\Middleware\Command;


use Post\Middleware\Request\UpdatePostRequest;
use Psr\Http\Message\ServerRequestInterface;

class UpdatePostCommand extends Command
{
	public function run(ServerRequestInterface $request){


		$postService = $this->getPostService();

		$postEntity = $postService->update(
			(new UpdatePostRequest($request))->getParameters()
		);

		return $postEntity;
	}

}