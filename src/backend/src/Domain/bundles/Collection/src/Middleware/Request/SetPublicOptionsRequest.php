<?php
namespace CASS\Domain\Collection\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use CASS\Domain\Collection\CollectionBundle;
use CASS\Domain\Collection\Parameters\SetPublicOptionsParameters;

final class SetPublicOptionsRequest extends SchemaParams
{
    public function getParameters(): SetPublicOptionsParameters
    {
        $data = $this->getData();

        return new SetPublicOptionsParameters(
            (bool) ($data['is_private'] ?? false),
            (bool) ($data['public_enabled'] ?? false),
            (bool) ($data['moderation_contract'] ?? false)
        );
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(CollectionBundle::class, './definitions/request/SetPublicOptionsRequest.yml');
    }
}