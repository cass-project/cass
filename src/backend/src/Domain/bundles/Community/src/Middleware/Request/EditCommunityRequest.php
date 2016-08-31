<?php
namespace Domain\Community\Middleware\Request;

use CASS\Application\REST\Request\Params\SchemaParams;
use CASS\Application\REST\Service\JSONSchema;
use Domain\Community\CommunityBundle;
use Domain\Community\Parameters\EditCommunityParameters;

class EditCommunityRequest extends SchemaParams
{
    public function getParameters(): EditCommunityParameters
    {
        $data = $this->getData();

        return new EditCommunityParameters(
            $data['title'],
            $data['description'],
            $data['theme_id'] ?? null
        );
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(CommunityBundle::class, './definitions/request/EditCommunityRequest.yml');
    }
}