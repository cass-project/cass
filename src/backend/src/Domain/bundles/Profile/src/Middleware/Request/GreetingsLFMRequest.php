<?php
namespace Domain\Profile\Middleware\Request;

use Application\Common\Service\JSONSchema;
use Application\Common\Tools\RequestParams\SchemaParams;
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