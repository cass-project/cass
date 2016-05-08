<?php
namespace Domain\ProfileIM\Middleware\Request;

use Application\Common\Service\JSONSchema;
use Application\Common\Tools\RequestParams\SchemaParams;
use Domain\ProfileIM\ProfileIMBundle;

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