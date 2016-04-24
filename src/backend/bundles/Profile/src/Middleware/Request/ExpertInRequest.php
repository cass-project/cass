<?php
namespace Profile\Middleware\Request;

use Common\Service\JSONSchema;
use Common\Tools\RequestParams\SchemaParams;
use Profile\Middleware\Parameters\ExpertInParameters;
use Profile\ProfileBundle;

class ExpertInRequest extends SchemaParams
{
    public function getParameters()
    {
        return new ExpertInParameters($this->getData()->theme_ids);
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ProfileBundle::class, './definitions/request/ExpertInRequest.yml');
    }
}