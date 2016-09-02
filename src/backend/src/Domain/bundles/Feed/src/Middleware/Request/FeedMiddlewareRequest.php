<?php
namespace CASS\Domain\Bundles\Feed\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use CASS\Domain\Bundles\Feed\FeedBundle;
use CASS\Domain\Bundles\Feed\Request\FeedRequest;

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