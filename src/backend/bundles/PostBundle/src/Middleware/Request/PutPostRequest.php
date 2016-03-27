<?php
/**
 * Created by PhpStorm.
 * User: CoffeeTurbo
 * Date: 23.03.2016
 * Time: 16:44
 */

namespace Post\Middleware\Request;


use Application\Service\JSONSchema;
use Application\Tools\RequestParams\Param;
use Application\Tools\RequestParams\SchemaParams;
use Data\Repository\Post\Parameters\CreatePostParameters;
use Post\PostBundle;

class PutPostRequest extends SchemaParams
{
	public function getParameters():CreatePostParameters
	{
		$data = $this->getData();

		$name = new Param($data, 'name', true);
		$description = new Param($data, 'description');
		$status = new Param($data, 'status');

		return new CreatePostParameters($name, $description, $status);
	}

	protected function getSchema(): JSONSchema
	{
		return self::getSchemaService()->getSchema(PostBundle::class, './definitions/request/PUTPostRequest.yml');
	}

}