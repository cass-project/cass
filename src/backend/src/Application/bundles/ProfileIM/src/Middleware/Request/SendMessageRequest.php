<?php
namespace Application\ProfileIM\Middleware\Request;

use Application\Common\Service\JSONSchema;
use Application\Common\Tools\RequestParams\SchemaParams;
use Application\ProfileIM\ProfileIMBundle;

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