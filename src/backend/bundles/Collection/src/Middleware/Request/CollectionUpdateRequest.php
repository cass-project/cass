<?php
namespace Collection\Middleware\Request;

use Collection\CollectionBundle;
use Collection\Service\Parameters\CollectionService\CollectionUpdateParameters;
use Common\Service\JSONSchema;
use Common\Tools\RequestParams\SchemaParams;

class CollectionUpdateRequest extends SchemaParams
{
    public function getParameters(): CollectionUpdateParameters
    {
        return new CollectionUpdateParameters($this->getData());
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(CollectionBundle::class, './definitions/request/CollectionUpdateRequest.yml');
    }
}