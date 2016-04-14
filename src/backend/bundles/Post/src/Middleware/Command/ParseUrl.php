<?php
/**
 * User: юзер
 * Date: 04.04.2016
 * Time: 15:40
 * To change this template use File | Settings | File Templates.
 */

namespace Post\Middleware\Command;


use Psr\Http\Message\ServerRequestInterface;

class ParseUrl extends Command
{
	public function run(ServerRequestInterface $request){
		$data = json_decode($request->getBody(), true);

		return ['entity' =>  $this->getPostService()->getLinkOptions($data['url'])];
	}

}