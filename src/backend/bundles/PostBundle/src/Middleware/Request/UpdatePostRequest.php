<?php
namespace Post\Middleware\Request;


use Application\Service\JSONSchema;
use Application\Tools\RequestParams\Param;
use Application\Tools\RequestParams\SchemaParams;
use Data\Repository\Post\Parameters\UpdatePostParameters;
use Post\PostBundle;

class UpdatePostRequest extends SchemaParams
{
	public function getParameters(){
		$data = $this->getData();

		$id = new Param($data, 'id');
		$name = new Param($data, 'name', true);
		$description = new Param($data, 'description');
		$status = new Param($data, 'status');

		return new UpdatePostParameters($name,$description,$status,$id);
	}

	protected function getSchema(): JSONSchema{
		return self::getSchemaService()->getSchema(PostBundle::class, './definitions/request/UpdatePostRequest.yml');
	}

}