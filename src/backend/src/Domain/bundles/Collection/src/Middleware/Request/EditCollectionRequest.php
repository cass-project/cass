<?php
namespace Domain\Collection\Middleware\Request;

use Application\REST\Request\Params\SchemaParams;
use Application\REST\Service\JSONSchema;
use Domain\Collection\CollectionBundle;
use Domain\Collection\Parameters\EditCollectionParameters;

class EditCollectionRequest extends SchemaParams
{
    public function getParameters(): EditCollectionParameters
    {
        $data = $this->getData();

        return new EditCollectionParameters(
            $data->title,
            $data->description,
            $data->theme_id ? $data->theme_id : null
        );
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(CollectionBundle::class, './definitions/request/EditCollectionRequest.yml');
    }
}