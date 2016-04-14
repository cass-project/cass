<?php
namespace Post\Middleware\Request;


use Common\Service\JSONSchema;
use Common\Tools\RequestParams\Param;
use Common\Tools\RequestParams\SchemaParams;
use Data\Repository\Post\CreateAttachmentParameters;
use Post\PostBundle;

class PutPostAttachmentRequest extends SchemaParams
{
	public function getParameters(){
		$data = $this->getData();

		$post_id = new Param($data, 'post_id');
		$url = new Param($data, 'url');

		return new CreateAttachmentParameters($post_id, $url);
	}

	protected function getSchema(): JSONSchema{
		return self::getSchemaService()->getSchema(PostBundle::class, './definitions/request/PUTPostAttachmentRequest.yml');
	}

}