<?php
namespace CASS\Domain\Bundles\IM\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use CASS\Domain\Bundles\IM\IMBundle;

class MessagesRequest extends SchemaParams
{
    public function getParameters()
    {
        return $this->getData();
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(IMBundle::class, './definitions/request/Messages.yml');
    }
}