<?php
namespace Profile\Middleware\Request;

use Common\Service\JSONSchema;
use Common\Tools\RequestParams\SchemaParams;
use Profile\ProfileBundle;

class UploadImageRequest extends SchemaParams
{
    public function getParameters()
    {
        return [
            ''
        ];
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ProfileBundle::class, './definitions/request/ProfileUploadImageRequest.yml');
    }
}