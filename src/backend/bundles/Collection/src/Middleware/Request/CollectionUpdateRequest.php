<?php
namespace Collection\Middleware\Request;

use Collection\CollectionBundle;
use Collection\Service\Parameters\CollectionService\CollectionUpdateParameters;
use Common\Service\JSONSchema;
use Common\Tools\RequestParams\Param;
use Common\Tools\RequestParams\SchemaParams;

class CollectionUpdateRequest extends SchemaParams
{
    public function getParameters(): CollectionUpdateParameters
    {
        $data = $this->getData();
        $request = $this->getRequest();

        $id = (int) $request->getAttribute('collectionId');
        $title = new Param($data, 'title', true);
        $description = new Param($data, 'description');
        $themeId = new Param($data, 'theme_id');
        $parentId = new Param($data, 'parent_id');
        $position = new Param($data, 'position');

        return new CollectionUpdateParameters($id, $title, $description, $themeId, $parentId, $position);
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(CollectionBundle::class, './definitions/request/CollectionUpdateRequest.yml');
    }
}