<?php
namespace Collection\Middleware\Request;

use Collection\CollectionBundle;
use Collection\Service\Parameters\CollectionService\CollectionCreateParameters;
use Common\Service\JSONSchema;
use Common\Tools\RequestParams\SchemaParams;

class CollectionCreateRequest extends SchemaParams
{
    public function getParameters(): CollectionCreateParameters
    {
        return new CollectionCreateParameters($this->getData());
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(CollectionBundle::class, './definitions/request/CollectionEntityRequest.yml');
    }
}