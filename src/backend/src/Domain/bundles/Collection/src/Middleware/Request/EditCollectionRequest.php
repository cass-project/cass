<?php
namespace CASS\Domain\Collection\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use CASS\Domain\Collection\CollectionBundle;
use CASS\Domain\Collection\Parameters\EditCollectionParameters;

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