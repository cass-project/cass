<?php
namespace Community\Middleware\Request;

use Common\Service\JSONSchema;
use Common\Tools\RequestParams\SchemaParams;
use Community\CommunityBundle;
use Community\Parameters\CreateCommunityParameters;

class CreateCommunityRequest extends SchemaParams
{
    public function getParameters(): CreateCommunityParameters
    {
        $data = $this->getData();

        return new CreateCommunityParameters(
            $data->title,
            $data->description,
            (int) $data->theme_id
        );
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(CommunityBundle::class, './definitions/request/CreateCommunityRequest.yml');
    }
}