<?php
namespace Domain\Collection\Middleware\Request;

use Application\REST\Request\Params\SchemaParams;
use Application\REST\Service\JSONSchema;
use Domain\Collection\CollectionBundle;
use Domain\Collection\Parameters\SetPublicOptionsParameters;

final class SetPublicOptionsRequest extends SchemaParams
{
    public function getParameters(): SetPublicOptionsParameters
    {
        $data = $this->getData();

        return new SetPublicOptionsParameters(
            (bool) $data->is_private,
            (bool) $data->public_enabled,
            (bool) $data->moderation_contract
        );
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(CollectionBundle::class, './definitions/request/SetPublicOptionsRequest.yml');
    }
}