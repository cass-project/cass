<?php
namespace Application\Profile\Middleware\Request;

use Application\Common\Service\JSONSchema;
use Application\Common\Tools\RequestParams\SchemaParams;
use Application\Profile\Middleware\Parameters\EditPersonalParameters;
use Application\Profile\ProfileBundle;

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