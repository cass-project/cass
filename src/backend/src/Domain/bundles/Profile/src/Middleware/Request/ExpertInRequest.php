<?php
namespace Domain\Profile\Middleware\Request;

use Application\REST\Service\JSONSchema;
use Domain\Request\Params\SchemaParams;
use Domain\Profile\Middleware\Parameters\ExpertInParameters;
use Domain\Profile\ProfileBundle;

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