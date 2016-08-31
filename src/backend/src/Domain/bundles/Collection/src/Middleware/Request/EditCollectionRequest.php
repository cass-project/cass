<?php
namespace Domain\Collection\Middleware\Request;

use CASS\Application\REST\Request\Params\SchemaParams;
use CASS\Application\REST\Service\JSONSchema;
use Domain\Collection\CollectionBundle;
use Domain\Collection\Parameters\EditCollectionParameters;

class EditCollectionRequest extends SchemaParams
{
    public function getParameters(): EditCollectionParameters
    {
        $data = $this->getData();

        return new EditCollectionParameters(
            $data['title'],
            $data['description'],
            $data['theme_ids'] ?? []
        );
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(CollectionBundle::class, './definitions/request/EditCollectionRequest.yml');
    }
}