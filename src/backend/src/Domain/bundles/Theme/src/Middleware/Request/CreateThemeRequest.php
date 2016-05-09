<?php
namespace Domain\Theme\Middleware\Request;

use Application\REST\Service\JSONSchema;
use Application\REST\Request\Params\SchemaParams;
use Domain\Theme\ThemeBundle;

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