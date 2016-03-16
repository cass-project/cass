<?php
/**
 * User: юзер
 * Date: 16.03.2016
 * Time: 16:42
 * To change this template use File | Settings | File Templates.
 */

namespace Channel\Middleware\Request;


use Application\Service\JSONSchema;
use Application\Tools\RequestParams\Param;
use Application\Tools\RequestParams\SchemaParams;
use Channel\ChannelBundle;
use Data\Repository\Channel\Parameters\UpdateChannelParameters;

class UpdateChannelRequest extends SchemaParams
{
	public function getParameters(){
		$data = $this->getData();

		$id = new Param($data, 'id', true);
		$name = new Param($data, 'name', true);
		$description = new Param($data, 'description');
		$status = new Param($data, 'status',true);
		$account_id = new Param($data, 'account_id');
		$theme_id = new Param($data, 'theme_id');

		return new UpdateChannelParameters($id, $name, $description, $status, $account_id,
																			 $theme_id
		);
	}

	protected function getSchema(): JSONSchema{
		return self::getSchemaService()->getSchema(ChannelBundle::class, './definitions/request/UpdateChannelRequest.yml');
	}

}