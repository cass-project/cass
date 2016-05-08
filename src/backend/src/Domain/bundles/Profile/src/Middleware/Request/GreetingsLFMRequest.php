<?php
namespace Domain\Profile\Middleware\Request;

use Application\REST\Service\JSONSchema;
use Application\REST\Request\Params\SchemaParams;
use Domain\Profile\ProfileBundle;

class GreetingsLFMRequest extends SchemaParams
{
    public function getParameters()
    {
        return (array) $this->getData();
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ProfileBundle::class, './definitions/request/GreetingsAsLFMRequest.yml');
    }
}