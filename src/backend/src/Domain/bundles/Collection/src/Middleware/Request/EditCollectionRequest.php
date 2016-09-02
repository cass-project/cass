<?php
namespace CASS\Domain\Bundles\Collection\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use CASS\Domain\Bundles\Collection\CollectionBundle;
use CASS\Domain\Bundles\Collection\Parameters\EditCollectionParameters;

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