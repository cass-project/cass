<?php

namespace Post\Middleware\Command;


use Common\Tools\RequestParams\Param;
use Post\Middleware\Request\PutPostAttachmentRequest;
use Post\Middleware\Request\PutPostRequest;
use Psr\Http\Message\ServerRequestInterface;

class CreateAttachmentCommand extends Command
{
	public function run(ServerRequestInterface $request){


		$json_r = json_decode($request->getBody(), true);
		if(isset($json_r['post_id']) && $json_r['post_id']){


			$postAttachmentParam = (new PutPostAttachmentRequest($request))
				->getParameters();
			$content = $this->getPostService()->getLinkOptions($postAttachmentParam->getUrl()->value());
			$postAttachmentParam->setContent(new Param(['content'=> json_encode($content)],'content'));
			$attachment = $this->getAttachmentService()->create($postAttachmentParam);
			return $attachment->toJSON();
		} else	{

			$post = $this->getPostService()->create(
				(new PutPostRequest($request))->getParameters()
			);

			$postAttachmentParam = (new PutPostAttachmentRequest($request))
				->getParameters();
			$postAttachmentParam->setContent(new Param(['content'=> $json_r], 'content'));

			$attachment = $this->getAttachmentService()->create(
				$postAttachmentParam
			);
			$post->addAttachment($attachment);
			return $this->getPostService()->save($post)->toJSON();
		}

	}
}