<?php
namespace Domain\Profile\Middleware\Request;

use Application\REST\Service\JSONSchema;
use Domain\Request\Params\SchemaParams;
use Domain\Profile\Middleware\Parameters\EditPersonalParameters;
use Domain\Profile\ProfileBundle;

class EditPersonalRequest extends SchemaParams
{
    public function getParameters()
    {
        return new EditPersonalParameters($this->getData());
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ProfileBundle::class, './definitions/request/EditPersonalRequest.yml');
    }
}