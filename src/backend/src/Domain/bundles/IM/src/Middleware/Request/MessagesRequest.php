<?php
namespace Domain\IM\Middleware\Request;

use CASS\Application\REST\Service\JSONSchema;
use CASS\Application\REST\Request\Params\SchemaParams;
use Domain\IM\IMBundle;

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