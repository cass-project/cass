<?php
namespace Domain\Feed\Middleware\Request;

use Application\REST\Request\Params\SchemaParams;
use Application\REST\Service\JSONSchema;
use Domain\Feed\FeedBundle;
use Domain\Feed\Request\FeedRequest;

final class FeedMiddlewareRequest extends SchemaParams
{
    public function getParameters(): array
    {
        return $this->getData();
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(FeedBundle::class, './definitions/request/FeedRequest.yml');
    }
}