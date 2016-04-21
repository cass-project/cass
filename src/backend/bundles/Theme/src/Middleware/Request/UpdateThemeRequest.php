<?php
namespace Theme\Middleware\Request;

use Common\Service\JSONSchema;
use Common\Tools\RequestParams\SchemaParams;
use Theme\ThemeBundle;

class UpdateThemeRequest extends SchemaParams
{
    public function getParameters() {
        $data = $this->getData();

        return [
            'title' => $data->title,
            'description' => $data->description
        ];
    }

    protected function getSchema(): JSONSchema {
        return self::getSchemaService()->getSchema(ThemeBundle::class, './definitions/request/UpdateThemeRequest.yml');
    }
}