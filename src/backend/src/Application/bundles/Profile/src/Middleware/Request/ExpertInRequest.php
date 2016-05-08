<?php
namespace Application\Profile\Middleware\Request;

use Application\Common\Service\JSONSchema;
use Application\Common\Tools\RequestParams\SchemaParams;
use Application\Profile\Middleware\Parameters\ExpertInParameters;
use Application\Profile\ProfileBundle;

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