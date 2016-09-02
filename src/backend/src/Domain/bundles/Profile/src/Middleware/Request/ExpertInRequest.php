<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use CASS\Domain\Bundles\Profile\Parameters\ExpertInParameters;
use CASS\Domain\Bundles\Profile\ProfileBundle;

class ExpertInRequest extends SchemaParams
{
    public function getParameters()
    {
        return new ExpertInParameters($this->getData()['theme_ids'] ?? []);
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ProfileBundle::class, './definitions/request/ExpertInRequest.yml');
    }
}