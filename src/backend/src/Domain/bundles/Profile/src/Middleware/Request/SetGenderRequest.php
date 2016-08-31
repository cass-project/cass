<?php
namespace Domain\Profile\Middleware\Request;

use CASS\Application\REST\Service\JSONSchema;
use CASS\Application\REST\Request\Params\SchemaParams;
use Domain\Profile\Parameters\SetGenderParameters;
use Domain\Profile\ProfileBundle;

class SetGenderRequest extends SchemaParams
{
    public function getParameters(): SetGenderParameters
    {
        return new SetGenderParameters($this->getData()['gender']);
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ProfileBundle::class, './definitions/request/SetGenderRequest.yml');
    }
}