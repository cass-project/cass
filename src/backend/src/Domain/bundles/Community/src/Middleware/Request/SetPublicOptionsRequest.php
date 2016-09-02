<?php
namespace CASS\Domain\Community\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use CASS\Domain\Community\CommunityBundle;
use CASS\Domain\Community\Parameters\EditCommunityParameters;
use CASS\Domain\Community\Parameters\SetPublicOptionsParameters;

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