<?php
namespace Application\Theme\Middleware\Request;

use Application\Common\Service\JSONSchema;
use Application\Common\Tools\RequestParams\SchemaParams;
use Application\Theme\ThemeBundle;

class CreateThemeRequest extends SchemaParams
{
    public function getParameters() {
        $data = $this->getData();

        return [
            'title' => $data->title,
            'description' => $data->description,
            'parent_id' => (string) $data->parent_id === "0" ? null : (int) $data->parent_id
        ];
    }

    protected function getSchema(): JSONSchema {
        return self::getSchemaService()->getSchema(ThemeBundle::class, './definitions/request/CreateThemeRequest.yml');
    }
}

