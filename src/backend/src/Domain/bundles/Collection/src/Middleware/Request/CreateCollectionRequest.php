<?php
namespace Domain\Collection\Middleware\Request;

use CASS\Application\REST\Request\Params\SchemaParams;
use CASS\Application\REST\Service\JSONSchema;
use Domain\Collection\CollectionBundle;
use Domain\Collection\Parameters\CreateCollectionParameters;

class CreateCollectionRequest extends SchemaParams
{
    public function getParameters(): CreateCollectionParameters
    {
        $data = $this->getData();

        return new CreateCollectionParameters(
            $data['owner_sid'],
            $data['title'],
            $data['description'],
            $data['theme_ids'] ?? []
        );
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(CollectionBundle::class, './definitions/request/CreateCollectionRequest.yml');
    }
}