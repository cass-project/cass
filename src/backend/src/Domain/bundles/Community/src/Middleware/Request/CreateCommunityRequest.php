<?php
namespace Domain\Community\Middleware\Request;

use Application\REST\Request\Params\SchemaParams;
use Application\REST\Service\JSONSchema;
use Domain\Community\CommunityBundle;
use Domain\Community\Parameters\CreateCommunityParameters;

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