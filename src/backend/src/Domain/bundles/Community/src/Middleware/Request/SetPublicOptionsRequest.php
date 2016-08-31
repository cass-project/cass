<?php
namespace Domain\Community\Middleware\Request;

use CASS\Application\REST\Request\Params\SchemaParams;
use CASS\Application\REST\Service\JSONSchema;
use Domain\Community\CommunityBundle;
use Domain\Community\Parameters\EditCommunityParameters;
use Domain\Community\Parameters\SetPublicOptionsParameters;

class SetPublicOptionsRequest extends SchemaParams
{
    public function getParameters(): SetPublicOptionsParameters
    {
        $data = $this->getData();

        return new SetPublicOptionsParameters(
            (bool) ($data['public_enabled'] ?? false),
            (bool) ($data['moderation_contract'] ?? false)
        );
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(CommunityBundle::class, './definitions/request/SetPublicOptionsRequest.yml');
    }
}