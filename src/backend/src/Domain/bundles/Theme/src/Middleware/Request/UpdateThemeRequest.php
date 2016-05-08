<?php
namespace Domain\Theme\Middleware\Request;

use Application\Common\Service\JSONSchema;
use Application\Common\Tools\RequestParams\SchemaParams;
use Domain\Theme\ThemeBundle;

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