<?php
namespace Domain\Profile\Middleware\Request;

use CASS\Application\REST\Service\JSONSchema;
use CASS\Application\REST\Request\Params\SchemaParams;
use Domain\Profile\ProfileBundle;

class GreetingsFLRequest extends SchemaParams
{
    public function getParameters()
    {
        return $this->getData();
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ProfileBundle::class, './definitions/request/GreetingsAsFLRequest.yml');
    }

}