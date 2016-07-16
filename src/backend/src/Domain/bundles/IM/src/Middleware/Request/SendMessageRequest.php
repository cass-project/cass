<?php
namespace Domain\IM\Middleware\Request;

use Application\REST\Service\JSONSchema;
use Application\REST\Request\Params\SchemaParams;
use Domain\IM\IMBundle;
use Domain\IM\Parameters\SendMessageParameters;

class SendMessageRequest extends SchemaParams
{
    public function getParameters(): SendMessageParameters
    {
        $data = $this->getData();

        return new SendMessageParameters($data['message'], $data['attachment_ids']);
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(IMBundle::class, './definitions/request/SendRequest.yml');
    }
}