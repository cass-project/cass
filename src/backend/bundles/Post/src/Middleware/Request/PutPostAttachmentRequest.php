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

		$post_id = new Param($data, 'post_id', true);
		$type = new Param($data, 'type');
		$content = new Param($data, 'content');

		return new CreateAttachmentParameters($post_id, $type, $content);
	}

	protected function getSchema(): JSONSchema{
		return self::getSchemaService()->getSchema(PostBundle::class, './definitions/request/PUTPostAttachmentRequest.yml');
	}

}