<?php
namespace CASS\Domain\Bundles\IM\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use CASS\Domain\Bundles\IM\IMBundle;
use CASS\Domain\Bundles\IM\Parameters\SendMessageParameters;

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