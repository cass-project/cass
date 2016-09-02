<?php
namespace CASS\Domain\Community\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use CASS\Domain\Community\CommunityBundle;
use CASS\Domain\Community\Parameters\CreateCommunityParameters;

class CreateCommunityRequest extends SchemaParams
{
    public function getParameters(): CreateCommunityParameters
    {
        $data = $this->getData();

        return new CreateCommunityParameters(
            $data['title'],
            $data['description'],
            $data['theme_id'] ?? null
        );
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(CommunityBundle::class, './definitions/request/CreateCommunityRequest.yml');
    }
}