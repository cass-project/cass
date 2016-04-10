<?php
namespace Profile\Middleware\Request;

use Common\Service\JSONSchema;
use Common\Tools\RequestParams\SchemaParams;
use Profile\Middleware\Parameters\EditPersonalParameters;
use Profile\ProfileBundle;

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