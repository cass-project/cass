<?php
namespace Theme\Middleware\Request;

use Common\Service\JSONSchema;
use Common\Tools\RequestParams\SchemaParams;
use Theme\ThemeBundle;

class UpdateThemeRequest extends SchemaParams
{
    public function getParameters() {
        throw new \Exception('Not implemented');
    }

    protected function getSchema(): JSONSchema {
        return self::getSchemaService()->getSchema(ThemeBundle::class, './definitions/request/UpdateThemeRequest.yml');
    }
}