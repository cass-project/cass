<?php
namespace Profile\Middleware\Request;

use Common\Service\JSONSchema;
use Common\Tools\RequestParams\SchemaParams;
use Profile\ProfileBundle;

class GreetingsNRequest extends SchemaParams
{
    public function getParameters()
    {
        return (array) $this->getData();
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ProfileBundle::class, './definitions/request/GreetingsAsNRequest.yml');
    }
}