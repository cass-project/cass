<?php
/**
 * Created by PhpStorm.
 * User: CoffeeTurbo
 * Date: 13.03.2016
 * Time: 17:06
 */

namespace Channel\Middleware\Request;


use Application\Service\JSONSchema;
use Application\Tools\RequestParams\Param;
use Application\Tools\RequestParams\SchemaParams;
use Channel\ChannelBundle;
use Data\Repository\Channel\Parameters\CreateChannelParemeters;

class PutChannelRequest extends SchemaParams
{


	public function getParameters()
	{
		$data = $this->getData();

		$name = new Param($data, 'name', true);
		$description = new Param($data, 'description');
		$status = new Param($data, 'status');
		$theme_id = new Param($data, 'theme');

		return new CreateChannelParemeters($name, $description, $status,
																			 $theme_id
		);
	}

	protected function getSchema(): JSONSchema
	{
		return self::getSchemaService()->getSchema(ChannelBundle::class, './definitions/request/PUTChannelRequest.yml');
	}


}