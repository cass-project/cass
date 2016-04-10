<?php
namespace ThemeEditor\Middleware\Request;

use Common\Tools\RequestParams\Param;
use Common\Service\JSONSchema;
use Common\Tools\RequestParams\SchemaParams;
use Data\Repository\Theme\Parameters\UpdateThemeParameters;
use ThemeEditor\ThemeEditorBundle;

class UpdateThemeRequest extends SchemaParams
{
    public function getParameters()
    {
        $data = $this->getData();
        $request = $this->getRequest();

        $themeId = (int) $request->getAttribute('themeId');
        $title = new Param($data, 'title', true);
        $parentId = new Param($data, 'parent_id');
        $position = new Param($data, 'position');

        return new UpdateThemeParameters($themeId, $title, $parentId, $position);
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ThemeEditorBundle::class, './definitions/request/UpdateThemeRequest.yml');
    }
}