<?php
namespace ProfileIM\Middleware\Request;

use Common\Service\JSONSchema;
use Common\Tools\RequestParams\SchemaParams;
use ProfileIM\ProfileIMBundle;

class SendMessageRequest extends SchemaParams
{
    public function getParameters()
    {
        throw new \Exception('Not implemented');
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ProfileIMBundle::class, './definitions/request/SendRequest.yml');
    }
}