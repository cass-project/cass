<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use CASS\Domain\Bundles\Profile\Parameters\InterestingInParameters;
use CASS\Domain\Bundles\Profile\ProfileBundle;

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