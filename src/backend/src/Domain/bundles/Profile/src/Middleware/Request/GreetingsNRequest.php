<?php
namespace Domain\Profile\Middleware\Request;

use Application\REST\Service\JSONSchema;
use Domain\Request\Params\SchemaParams;
use Domain\Profile\ProfileBundle;

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