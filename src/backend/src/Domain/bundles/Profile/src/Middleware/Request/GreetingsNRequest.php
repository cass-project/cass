<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use CASS\Domain\Bundles\Profile\ProfileBundle;

class GreetingsNRequest extends SchemaParams
{
    public function getParameters()
    {
        return $this->getData();
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ProfileBundle::class, './definitions/request/GreetingsAsNRequest.yml');
    }
}