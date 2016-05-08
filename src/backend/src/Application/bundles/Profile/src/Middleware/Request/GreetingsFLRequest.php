<?php
namespace Application\Profile\Middleware\Request;

use Application\Common\Service\JSONSchema;
use Application\Common\Tools\RequestParams\SchemaParams;
use Application\Profile\ProfileBundle;

class GreetingsFLRequest extends SchemaParams
{
    public function getParameters()
    {
        return (array) $this->getData();
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ProfileBundle::class, './definitions/request/GreetingsAsFLRequest.yml');
    }

}