<?php
namespace Domain\Profile\Middleware\Request;

use Application\Common\Service\JSONSchema;
use Application\Common\Tools\RequestParams\SchemaParams;
use Domain\Profile\Middleware\Parameters\ExpertInParameters;
use Domain\Profile\Middleware\Parameters\InterestingInParameters;
use Domain\Profile\ProfileBundle;

class InterestingInRequest extends SchemaParams
{
    public function getParameters()
    {
        return new InterestingInParameters($this->getData()->theme_ids);
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ProfileBundle::class, './definitions/request/InterestingInRequest.yml');
    }
}