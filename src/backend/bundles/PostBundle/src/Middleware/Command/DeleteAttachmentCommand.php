<?php

namespace Post\Middleware\Command;


use Psr\Http\Message\ServerRequestInterface;

class DeleteAttachmentCommand extends Command
{
	public function run(ServerRequestInterface $request)
	{

		$attachId = $request->getAttribute('attachmentId');
		$this->getAttachmentService()->getAttachmentRepository()->delete($attachId);
		return [];
	}

}