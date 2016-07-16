<?php
namespace Domain\IM\Middleware\Request;

use Application\REST\Service\JSONSchema;
use Application\REST\Request\Params\SchemaParams;
use Domain\IM\IMBundle;

class MessagesRequest extends SchemaParams
{
    public function getParameters()
    {
        throw new \Exception('Not implemented');
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(IMBundle::class, './definitions/request/Messages.yml');
    }
}