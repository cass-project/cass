<?php
namespace Post\Middleware\Request;


use Common\Service\JSONSchema;
use Common\Tools\RequestParams\Param;
use Common\Tools\RequestParams\SchemaParams;
use Data\Repository\Post\Parameters\CreatePostParameters;
use Post\PostBundle;

class PutPostRequest extends SchemaParams
{
	public function getParameters():CreatePostParameters
	{
		$data = $this->getData();

		$name = new Param($data, 'name', true);
		$description = new Param($data, 'description');

		return new CreatePostParameters($name, $description);
	}

	protected function getSchema(): JSONSchema
	{
		return self::getSchemaService()->getSchema(PostBundle::class, './definitions/request/PUTPostRequest.yml');
	}

}