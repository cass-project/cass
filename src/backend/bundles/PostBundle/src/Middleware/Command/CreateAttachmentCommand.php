<?php

namespace Post\Middleware\Command;


use Post\Middleware\Request\PutPostAttachmentRequest;
use Psr\Http\Message\ServerRequestInterface;

class CreateAttachmentCommand extends Command
{
	public function run(ServerRequestInterface $request){
		$postAttachmentParam = (new PutPostAttachmentRequest($request))->getParameters();
		$attachment = $this->getAttachmentService()->create($postAttachmentParam);
		return $attachment->toJSON();
	}
}