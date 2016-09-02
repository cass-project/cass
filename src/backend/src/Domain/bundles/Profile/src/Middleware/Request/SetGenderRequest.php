<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use CASS\Domain\Bundles\Profile\Parameters\SetGenderParameters;
use CASS\Domain\Bundles\Profile\ProfileBundle;

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