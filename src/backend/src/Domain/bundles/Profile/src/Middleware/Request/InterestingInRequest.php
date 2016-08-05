<?php
namespace Domain\Profile\Middleware\Request;

use Application\REST\Request\Params\SchemaParams;
use Application\REST\Service\JSONSchema;
use Domain\Profile\Parameters\InterestingInParameters;
use Domain\Profile\ProfileBundle;

class InterestingInRequest extends SchemaParams
{
    public function getParameters()
    {
        return new InterestingInParameters($this->getData()['theme_ids'] ?? []);
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ProfileBundle::class, './definitions/request/InterestingInRequest.yml');
    }
}