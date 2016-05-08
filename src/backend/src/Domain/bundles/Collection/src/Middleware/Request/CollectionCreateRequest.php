<?php
namespace Domain\Collection\Middleware\Request;

use Domain\Collection\CollectionBundle;
use Domain\Collection\Service\Parameters\CollectionService\CollectionCreateParameters;
use Application\REST\Service\JSONSchema;
use Application\REST\Request\Params\Param;
use Application\REST\Request\Params\SchemaParams;

class CollectionCreateRequest extends SchemaParams
{
    public function getParameters(): CollectionCreateParameters
    {
        $data = $this->getData();

        $title = new Param($data, 'title', true);
        $description = new Param($data, 'description');
        $themeId = new Param($data, 'theme_id');
        $parentId = new Param($data, 'parent_id');
        $position = new Param($data, 'position');

        return new CollectionCreateParameters($title, $description, $themeId, $parentId, $position);
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(CollectionBundle::class, './definitions/request/CollectionEntityRequest.yml');
    }
}